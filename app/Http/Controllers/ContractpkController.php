<?php

namespace App\Http\Controllers;

use App\Imports\ContractpkImport;
use App\Models\Contractpk;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ContractpkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $cpk = Contractpk::orderBy('id', 'desc')->get();

        return view('cpk.index', compact('cpk'));
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
