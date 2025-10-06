<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Aresta;
use Illuminate\Http\Request;
use Termwind\Components\Raw;
use App\Imports\ArestaImport;
use Illuminate\Support\Facades\DB;
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

        return view('aresta.index', compact('labels1', 'values1', 'labels2', 'values2'));
    }

    public function data(Request $request)
    {
        $query = Aresta::select([
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

        if($request->minDate && $request->maxDate) {
            $query->whereBetween('bulan', [$request->minDate, $request->maxDate]);
        } elseif ($request->minDate) {
            $query->whereDate('bulan', '>=', $request->minDate);
        } elseif ($request->maxDate) {
            $query->whereDate('bulan', '<=', $request->maxDate);
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

        Aresta::create($request->all());
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
        $Aresta = Aresta::findOrFail($id);
        return view('aresta.edit', ['Aresta' => $Aresta]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $Aresta_update = Aresta::findOrFail($id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $aresta = Aresta::findOrFail($id);
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
}
