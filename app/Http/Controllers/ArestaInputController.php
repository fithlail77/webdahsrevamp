<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aresta;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ArestaImport;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Raw;

class ArestaInputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aresta = Aresta::where('bulan', '>=', Carbon::now()->subDays(30))
            ->orderBy('bulan', 'desc')
            ->get();

        $aresta1 = Aresta::select(
            'estate',
            'divisi',
            'blok',
            'status_lahan',
            'status_tanaman',
            'tahun_tanam',
            'topografi',
            'jenis_tanah',
            DB::raw('sum(luas) as luasan'),
            DB::raw('sum(pokok) as jlh_pokok'),
            DB::raw('CASE WHEN sum(luas) = 0 THEN 0 ELSE ROUND(sum(pokok)::numeric /sum(luas)) END as sph')
        )
            ->groupBy('blok', 'estate', 'divisi', 'status_lahan', 'status_tanaman', 'tahun_tanam', 'topografi', 'jenis_tanah')
            ->orderBy('blok', 'asc')
            ->havingRaw('sum(luas) > 0')
            ->havingRaw('CASE WHEN sum(luas) = 0 THEN 0 ELSE ROUND(sum(pokok)::numeric / sum(luas)) END > 0')
            ->get();

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

        return view('aresta.index', compact('aresta', 'aresta1', 'labels1', 'values1', 'labels2', 'values2'));
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
