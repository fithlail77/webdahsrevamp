<?php

namespace App\Http\Controllers;

use App\Exports\CurahHujanExport;
use App\Exports\CurahHujanPdfExport;
use Carbon\Carbon;
use App\Models\ChInput;
use App\Imports\ChImport;
use App\Models\CurahHujan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ChInputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$ChInput = ChInput::where('dates', '>=', Carbon::now()->subDays(30))
        //    ->where('pt', 'GUM')
        //    ->orderBy('dates', 'desc')
        //    ->get();

        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        $tanggalLengkap = [];
        $current = $start->copy();
        while ($current <= $end) {
            $tanggalLengkap[$current->format('d')] = 0; // default value 0
            $current->addDay();
        }

        $chart1 = DB::table('curah_hujan')
            ->selectRaw('DATE(dates) as tanggal , ROUND(AVG(ch), 2) AS avg_ch')
            ->where('pt', 'GUM')
            ->whereBetween('dates', [$start, $end])
            ->groupByRaw('DATE(dates)')
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::parse($item->tanggal)->format('d') => round($item->avg_ch, 2)];
                    })
            ->toArray();
        
        $result = [];
            foreach ($tanggalLengkap as $tgl => $value) {
                $result[] = $chart1[$tgl] ?? 0;
        }

        $labels1 = array_keys($tanggalLengkap);
        $chart1 = $result;


        return view('ch.index', compact('labels1', 'chart1'));
    }

    public function data(Request $request)
    {
        $query = ChInput::select([
            'id',
            'pt',
            'dates',
            'estate',
            'divisi',
            'ch'
        ])
        ->orderBy('dates','desc');

        // Jika ada pencarian global, ambil semua data tanpa filter tanggal
        if (!empty($request->input('search.value'))) {
            // Tidak ada filter tanggal, ambil semua
        } else {
            // Jika ada filter tanggal, gunakan itu
            if($request->minDate && $request->maxDate) {
                $query->whereBetween('dates', [$request->minDate, $request->maxDate]);
            } elseif ($request->minDate) {
                $query->whereDate('dates', '>=', $request->minDate);
            } elseif ($request->maxDate) {
                $query->whereDate('dates', '<=', $request->maxDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('dates', '>=', Carbon::now()->subDays(30));
            }
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('tanggal_formatted', function ($row) {
                return \Carbon\Carbon::parse($row['dates'])->format('d-m-Y');
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditCurahHujan"><i class="fa fa-edit"></i></a>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ch.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'ChInput.*.pt' => 'required|string',
            'ChInput.*.dates' => 'required|date',
            'ChInput.*.estate' => 'required|string',
            'ChInput.*.divisi' => 'required|string',
            'ChInput.*.ch' => 'required|numeric',
        ]);

        foreach ($request->ChInput as $row) {
            ChInput::create([
                'pt' => $row['pt'],
                'dates' => $row['dates'],
                'estate' => $row['estate'],
                'divisi' => $row['divisi'], 
                'ch' => $row['ch'],
            ]);
        }

        return redirect()->route('curah.index')->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $curah = ChInput::findOrFail($id);
            return response()->json($curah);
        } catch (\Exception $e) {
            Log::error('Error in edit Method: ' . $e->getMessage() . ' ID: ' . $id);
            return response()->json(['error' => 'Data tidak ditemukan: ' . $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'pt' => 'required|string',
                'dates' => 'required|date',
                'estate' => 'required|string',
                'divisi' => 'required|integer',
                'ch' => 'required|numeric'
            ]);

            $curah = ChInput::findOrFail($id);
            $curah->update($request->only(['pt', 'dates', 'estate', 'divisi', 'ch']));

            return response()->json(['success' => 'Data berhasil diperbarui.']);
        } catch (\Exception $e) {
            Log::error('Error updating Curah Hujan: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $chInput = ChInput::findOrFail($id);
        $chInput->delete();
        return redirect()->route('curah.index')->with('success', 'Data berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        Excel::import(new ChImport, $request->file('file'));

        return redirect()->route('curah.index')->with('success', 'Data berhasil diupload.');
    }

    public function exportExcel(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $search = $request->input('search');

        return Excel::download(new CurahHujanExport($minDate, $maxDate, $search), 'Curah_Hujan.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $search = $request->input('search');

        $pdfExport = new CurahHujanPdfExport($minDate, $maxDate, $search);
        return $pdfExport->generatePdf();
    }
}
