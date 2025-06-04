<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Contractcpo;
use Illuminate\Http\Request;
use App\Imports\ContractcpoImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ContractcpoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ccpo = Contractcpo::orderBy('real_loading_tk', 'desc')->get();

        $chart1 = DB::table('contract_cpo')
                    ->select('real_loading_tk', 'real_price')
                    ->whereBetween('real_loading_tk', [
                        DB::raw("DATE_TRUNC('month', CURRENT_DATE - INTERVAL '2 month')"),
                        DB::raw("DATE_TRUNC('month', CURRENT_DATE) - INTERVAL '1 day'")
                        ])
                    ->orderBy('real_loading_tk')
                    ->get();
        
        $labels1 = $chart1->pluck('real_loading_tk')->map(fn($date) => Carbon::parse($date)->format('d M Y'))->toArray(); // contoh: "01"
        $values1 = $chart1->pluck('real_price')->toArray();

        $chart2 = DB::table('contract_cpo')
                    ->select('real_loading_tk', 'real_qty_kg')
                    ->whereBetween('real_loading_tk', [
                        DB::raw("DATE_TRUNC('month', CURRENT_DATE - INTERVAL '2 month')"),
                        DB::raw("DATE_TRUNC('month', CURRENT_DATE) - INTERVAL '1 day'")
                        ])
                    ->orderBy('real_loading_tk')
                    ->get();
        
        $labels2 = $chart2->pluck('real_loading_tk')->map(fn($date) => Carbon::parse($date)->format('d M Y'))->toArray(); // contoh: "01"
        $values2 = $chart2->pluck('real_qty_kg')->toArray();

        return view('ccpo.index', compact('ccpo','labels1','values1','labels2','values2'));
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

        Excel::import(new ContractcpoImport, $request->file('file'));

        return redirect()->route('contractcpo.index')->with('success', 'Data berhasil diupload.');
    }
}
