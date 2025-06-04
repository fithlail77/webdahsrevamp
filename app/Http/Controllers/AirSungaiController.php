<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AirSungai;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AirSungaiImport;
use Carbon\Carbon;

class AirSungaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sungai = AirSungai::where('tanggal', '>=', Carbon::now()->subDays(30))
            ->orderBy('tanggal', 'desc')
            ->get();

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

        return view('airsungai.index', compact('sungai','labels1', 'values1'));
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
        $sungai = AirSungai::findOrFail($id);
        return view('airsungai.edit', ['AirSungai' => $sungai]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sungai = AirSungai::findOrFail($id);
        $sungai->tanggal = $request->get('tanggal');
        $sungai->pagi_m = $request->get('pagi_m');
        $sungai->sore_m = $request->get('sore_m');
        $sungai->rataan = $request->get('rataan');
        $sungai->save();

        return redirect()->route('airsungai.index')->with('success', 'Data berhasil diubah.');
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
}
