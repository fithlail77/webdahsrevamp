<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ArestaOld;
use App\Models\Company;
use Illuminate\Http\Request;
use Termwind\Components\Raw;
use App\Exports\ArestaExport;
use App\Imports\ArestaImport;
use App\Exports\ArestaPdfExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ArestaInputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$aresta = Aresta::where('bulan', '>=', Carbon::now()->subDays(30))
        //    ->orderBy('bulan', 'desc')
        //    ->get();

        $chart1 = DB::table('aresta')
            ->select('estate', DB::raw('SUM(pokok) as tot_pokok'))
            ->groupBy('estate')
            ->orderBy('estate','asc')
            ->get();
        
        $labels1 = $chart1->pluck('estate');
        $values1 = $chart1->pluck('tot_pokok');

        $chart2 = DB::table('aresta')
            ->select('estate', DB::raw('SUM(luas) as tot_luas'))
            ->groupBy('estate')
            ->orderBy('estate','asc')
            ->get();
        
        $labels2 = $chart2->pluck('estate');
        $values2 = $chart2->pluck('tot_luas');

        $estate = Company::select('estate')
            ->distinct()
            ->get();

        $divisi = Company::select('divisi')
            ->distinct()
            ->orderBy('divisi','asc')
            ->get();

        return view('aresta.index', compact('labels1', 'values1', 'labels2', 'values2', 'estate', 'divisi'));
    }

    public function data(Request $request)
    {
        $query = ArestaOld::select([
            'id',
            'bulan',
            'estate',
            'divisi',
            'blok',
            'tahun_tanam',
            'status_tanaman',
            'status_lahan',
            'jenis_bibit',
            'topografi',
            'jenis_tanah',
            'pokok',
            'luas'
        ])
        ->orderBy('bulan','desc');

        // Filter berdasarkan estate user
        $userEstate = Auth::user()->estate ?? null;
        if ($userEstate && $userEstate !== 'all') {
            $query->where('estate', $userEstate);
        }

        // Jika ada pencarian global, ambil semua data tanpa filter tanggal
        if (!empty($request->input('search.value'))) {
            // Tidak ada filter tanggal, ambil semua
        } else {
            // Jika ada filter tanggal, gunakan itu
            if($request->minDate && $request->maxDate) {
                $query->whereBetween('bulan', [$request->minDate, $request->maxDate]);
            } elseif ($request->minDate) {
                $query->whereDate('bulan', '>=', $request->minDate);
            } elseif ($request->maxDate) {
                $query->whereDate('bulan', '<=', $request->maxDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('bulan', '>=', Carbon::now()->subDays(30));
            }
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('tanggal_formatted', function ($row) {
                return \Carbon\Carbon::parse($row['bulan'])->format('d-m-Y');
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditAresta"><i class="fa fa-edit"></i></a>
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
        return view('aresta.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'bulan' => 'required',
            'estate' => 'required|string',
            'divisi' => 'required|integer',
            'blok' => 'required|string',
            'tahun_tanam' => 'required|string',
            'status_tanaman' => 'required|string',
            'status_lahan' => 'required|string',
            'jenis_bibit' => 'required|string',
            'topografi' => 'required|string',
            'jenis_tanah' => 'required|string',
            'pokok' => 'required|integer',
            'luas' => 'required|numeric',
            'jenis_input' => 'required|string',
        ]);

        ArestaOld::create($request->all());
        return redirect()->route('areal.index')->with('success', 'Areal berhasil ditambahkan.');
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
            $aresta = ArestaOld::findOrFail($id);
            return response()->json($aresta);
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
                'bulan' => 'required|date',
                'estate' => 'required|string|max:10',
                'divisi' => 'required|integer',
                'blok' => 'required|string|max:3',
                'tahun_tanam' => 'required|integer',
                'status_tanaman' => 'required|string|max:3',
                'status_lahan' => 'required|string|max:10',
                'jenis_bibit' => 'required|string|max:20',
                'topografi' => 'required|string|max:20',
                'jenis_tanah' => 'required|string|max:20',
                'pokok' => 'required|integer',
                'luas' => 'required|numeric'
            ]);

            $aresta = ArestaOld::findOrFail($id);
            $aresta->update($request->all());

            return response()->json(['success' => 'Data berhasil diperbarui.']);
        } catch (\Exception $e) {
            Log::error('Error updating Aresta: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $aresta = ArestaOld::findOrFail($id);
        $aresta->delete();
        return redirect()->route('areal.index')->with('success', 'Data berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        Excel::import(new ArestaImport, $request->file('file'));

        return redirect()->route('areal.index')->with('success', 'Data berhasil diupload.');
    }

    public function exportExcel(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $search = $request->input('search');

        return Excel::download(new ArestaExport($minDate, $maxDate, $search), 'Areal_Statement.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $search = $request->input('search');

        $pdfExport = new ArestaPdfExport($minDate, $maxDate, $search);
        return $pdfExport->generatePdf();
    }
}
