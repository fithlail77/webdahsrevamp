<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AirSungai;
use Illuminate\Http\Request;
use App\Exports\AirSungaiExport;
use App\Imports\AirSungaiImport;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Exports\AirSungaiPdfExport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class AirSungaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$sungai = AirSungai::where('tanggal', '>=', Carbon::now()->subDays(30))
        //    ->orderBy('tanggal', 'desc')
        //    ->get();

        $chart1 = DB::table('air_sungais')
            ->select('tanggal', DB::raw('ROUND(rataan, 2) as rataan'))
            ->whereNotNull('rataan') // ini penting!
            ->where('tanggal', '>=', DB::raw("CURRENT_DATE - INTERVAL '30 days'"))
            ->orderBy('tanggal', 'asc')
            ->get();
        
        // Ambil label dan data untuk chart
        $labels1 = $chart1->pluck('tanggal')->map(function ($date) {
            return \Carbon\Carbon::parse($date)->format('d M');
        });

        $values1 = $chart1->pluck('rataan');

        return view('airsungai.index', compact('labels1', 'values1'));
    }

    public function data(Request $request)
    {
        $query = AirSungai::select([
            'id',
            'tanggal',
            'pagi_m',
            'sore_m',
            'rataan',
        ])
        ->orderBy('tanggal','desc');

        // Jika ada pencarian global, ambil semua data tanpa filter tanggal
        if (!empty($request->input('search.value'))) {
            // Tidak ada filter tanggal, ambil semua
        } else {
            // Jika ada filter tanggal, gunakan itu
            if($request->minDate && $request->maxDate) {
                $query->whereBetween('tanggal', [$request->minDate, $request->maxDate]);
            } elseif ($request->minDate) {
                $query->whereDate('tanggal', '>=', $request->minDate);
            } elseif ($request->maxDate) {
                $query->whereDate('tanggal', '<=', $request->maxDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('tanggal', '>=', Carbon::now()->subDays(30));
            }
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('tanggal_formatted', function ($row) {
                return \Carbon\Carbon::parse($row['tanggal'])->format('d-m-Y');
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditAirSungai"><i class="fa fa-edit"></i></a>
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
        return view('airsungai.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'pagi_m' => 'integer',
            'sore_m' => 'integer',
            'rataan' => 'numeric'
        ]);

        AirSungai::create($request->all());
        return redirect()->route('airsungai.index')->with('success', 'Data berhasil ditambahkan.');
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
            $airsungai = AirSungai::findOrFail($id);
            return response()->json($airsungai);
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
                'tanggal' => 'required|date',
                'pagi_m' => 'required|integer',
                'sore_m' => 'required|integer',
                'rataan' => 'required|numeric'
            ]);

            $airsungai = AirSungai::findOrFail($id);
            $airsungai->update($request->all());

            return response()->json(['success' => 'Data berhasil diperbarui.']);
        } catch (\Exception $e) {
            Log::error('Error updating Air Sungai ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sungai = AirSungai::findOrFail($id);
        $sungai->delete();
        return redirect()->route('airsungai.index')->with('success', 'Data berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        Excel::import(new AirSungaiImport, $request->file('file'));

        return redirect()->route('airsungai.index')->with('success', 'Data berhasil diupload.');
    }

    public function exportExcel(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $search = $request->input('search');

        return Excel::download(new AirSungaiExport($minDate, $maxDate, $search), 'Air_Sungai.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $search = $request->input('search');

        $pdfExport = new AirSungaiPdfExport($minDate, $maxDate, $search);
        return $pdfExport->generatePdf();
    }
}
