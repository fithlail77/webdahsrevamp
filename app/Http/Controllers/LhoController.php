<?php

namespace App\Http\Controllers;

use App\Imports\LhobbmImport;
use App\Models\LhoBbm;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LhoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lhobbm = LhoBbm::whereRaw("i_date >= date_trunc('month', CURRENT_DATE - INTERVAL '1 month')")
                    ->whereRaw("i_date < date_trunc('month', CURRENT_DATE)")
                    ->orderBy('i_date', 'desc')
                    ->get();

        return view('lho.index', compact('lhobbm'));
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

        Excel::import(new LhobbmImport, $request->file('file'));

        return redirect()->route('lho.index')->with('success', 'Data berhasil diupload.');

    }
}
