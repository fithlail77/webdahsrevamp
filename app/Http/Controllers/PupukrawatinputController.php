<?php

namespace App\Http\Controllers;

use App\Models\Pupukrawat;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PupukImport;

class PupukrawatinputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pupuk = Pupukrawat::whereRaw("issue_date >= date_trunc('month', CURRENT_DATE - INTERVAL '1 month')")
            ->whereRaw("issue_date < date_trunc('month', CURRENT_DATE)")
            ->orderBy('issue_date', 'desc')
            ->get();
        
        return view('pupuk.index', compact('pupuk'));
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
        $pupuk = Pupukrawat::findOrFail($id);
        $pupuk->delete();
        return redirect()->route('pupuk.index')->with('success', 'Data berhasil dihapus.');
    }

    public function import(request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        Excel::import(new PupukImport, $request->file('file'));

        //dd($request);

        return redirect()->route('pupuk.index')->with('success', 'Data berhasil diupload.');
    }
}
