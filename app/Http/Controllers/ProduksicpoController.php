<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Produksicpo;
use Illuminate\Http\Request;
use App\Imports\ProduksicpoImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ProduksicpoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cpo = Produksicpo::where('tanggal', '>=', Carbon::now()->subDays(30))
        ->orderBy('tanggal', 'desc')
        ->get();

        $chart1 = DB::table('produksi_cpo')
            ->select('tanggal', 'cpo_produksi_today')
            ->whereBetween('tanggal', [
                DB::raw("DATE_TRUNC('month', CURRENT_DATE)"),
                DB::raw("DATE_TRUNC('month', CURRENT_DATE) + INTERVAL '1 month - 1 day'")
            ])
            ->orderBy('tanggal')
            ->get();
        
        $labels1 = $chart1->pluck('tanggal')->map(fn($date) => Carbon::parse($date)->format('d'))->toArray(); // contoh: "01"
        $values1 = $chart1->pluck('cpo_produksi_today')->toArray();

        $chart2 = DB::table('produksi_cpo')
            ->select('tanggal', 'kernel_produksi')
            ->whereBetween('tanggal', [
                DB::raw("DATE_TRUNC('month', CURRENT_DATE)"),
                DB::raw("DATE_TRUNC('month', CURRENT_DATE) + INTERVAL '1 month - 1 day'")
            ])
            ->orderBy('tanggal')
            ->get();
        
        $labels2 = $chart2->pluck('tanggal')->map(fn($date) => Carbon::parse($date)->format('d'))->toArray(); // contoh: "01"
        $values2 = $chart2->pluck('kernel_produksi')->toArray();

        return view('cpo.index', compact('cpo','labels1','values1','labels2','values2'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function import(request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        Excel::import(new ProduksicpoImport, $request->file('file'));

        return redirect()->route('produksicpo.index')->with('success', 'Data berhasil diupload.');
    }
}
