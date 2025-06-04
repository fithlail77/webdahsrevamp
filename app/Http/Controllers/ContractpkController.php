<?php

namespace App\Http\Controllers;

use App\Imports\ContractpkImport;
use App\Models\Contractpk;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ContractpkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cpk = Contractpk::orderBy('id', 'desc')->get();

        $chart1 = DB::table('contract_kernel')
                    ->select('date_pricing', 'real_price')
                    ->whereBetween('date_pricing', [
                            DB::raw("DATE_TRUNC('month', CURRENT_DATE - INTERVAL '6 month')"),
                            DB::raw("DATE_TRUNC('month', CURRENT_DATE) - INTERVAL '1 day'")
                        ])
                    ->orderBy('date_pricing')
                    ->get();
        
        $labels1 = $chart1->pluck('date_pricing')->map(fn($date) => Carbon::parse($date)->format('d M Y'))->toArray(); // contoh: "01"
        $values1 = $chart1->pluck('real_price')->toArray();
        
        $chart2 = DB::table('contract_kernel')
                    ->select('date_pricing', 'real_qty_kg')
                    ->whereBetween('date_pricing', [
                            DB::raw("DATE_TRUNC('month', CURRENT_DATE - INTERVAL '6 month')"),
                            DB::raw("DATE_TRUNC('month', CURRENT_DATE) - INTERVAL '1 day'")
                        ])
                    ->orderBy('date_pricing')
                    ->get();
        
        $labels2 = $chart2->pluck('date_pricing')->map(fn($date) => Carbon::parse($date)->format('d M Y'))->toArray(); // contoh: "01"
        $values2 = $chart2->pluck('real_qty_kg')->toArray();

        return view('cpk.index', compact('cpk','labels1','values1','labels2','values2'));
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

        Excel::import(new ContractpkImport, $request->file('file'));

        return redirect()->route('contractpk.index')->with('success', 'Data berhasil diupload.');
    }
}
