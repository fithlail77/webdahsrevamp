<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use Illuminate\Http\Request;
use App\Imports\PayrollImport;
use Maatwebsite\Excel\Facades\Excel;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payroll = Payroll::whereRaw("tanggal >= date_trunc('month', CURRENT_DATE - INTERVAL '1 month')")
            ->whereRaw("tanggal < date_trunc('month', CURRENT_DATE)")
            ->orderBy('tanggal', 'desc')
            ->get();
        
        return view('payroll.index', compact('payroll'));
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

        Excel::import(new PayrollImport, $request->file('file'));

        //dd($request);
        return redirect()->route('payroll.index')->with('success', 'Data berhasil diupload.');
    }
}
