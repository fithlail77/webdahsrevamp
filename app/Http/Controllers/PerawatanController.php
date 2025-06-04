<?php

namespace App\Http\Controllers;

use App\Models\Perawatan;
use Illuminate\Http\Request;
use App\Imports\PerawatanImport;
use Maatwebsite\Excel\Facades\Excel;

class PerawatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rawat = Perawatan::whereRaw("tanggal >= date_trunc('month', CURRENT_DATE - INTERVAL '1 month')")
            ->whereRaw("tanggal < date_trunc('month', CURRENT_DATE)")
            ->orderBy('tanggal', 'desc')
            ->get();
        
        return view('rawat.index', compact('rawat'));
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
        $rawat = Perawatan::findOrFail($id);
        $rawat->delete();
        return redirect()->route('perawatan.index')->with('success', 'Data berhasil dihapus.');
    }

    public function import(request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        Excel::import(new PerawatanImport, $request->file('file'));

        return redirect()->route('perawatan.index')->with('success', 'Data berhasil diupload.');
    }
}
