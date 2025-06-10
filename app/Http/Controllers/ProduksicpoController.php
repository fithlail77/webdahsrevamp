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

        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        $tanggalLengkap = [];
        $current = $start->copy();
        while ($current <= $end) {
            $tanggalLengkap[$current->format('d')] = 0; // default value 0
            $current->addDay();
        }

        $chart1 = DB::table('produksi_cpo')
            ->selectRaw('DATE(tanggal) as tanggal, cpo_produksi_today')
            ->whereBetween('tanggal', [$start, $end])
            ->orderByRaw('DATE(tanggal)')
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::parse($item->tanggal)->format('d') => (int) $item->cpo_produksi_today];
                    })
            ->toArray();
        
        $result = [];
            foreach ($tanggalLengkap as $tgl => $value) {
                $result[] = $chart1[$tgl] ?? 0;
        }
        
        $labels1 = array_keys($tanggalLengkap);
        $chart1 = $result;

        $chart2 = DB::table('produksi_cpo')
            ->selectRaw('DATE(tanggal) as tanggal, kernel_produksi')
            ->whereBetween('tanggal', [$start, $end])
            ->orderByRaw('DATE(tanggal)')
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::parse($item->tanggal)->format('d') => (int) $item->kernel_produksi];
                    })
            ->toArray();
        
        $result2 = [];
            foreach ($tanggalLengkap as $tgl => $value) {
                $result2[] = $chart2[$tgl] ?? 0;
        }
        
        $chart2 = $result2;

        return view('cpo.index', compact('cpo','labels1','chart1','chart2'));
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
