<?php

namespace App\Http\Controllers;

use App\Imports\LhoinputImport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LhoinputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results = DB::table('input')
            ->select([
                'id',
                'tgl',
                'no_unit',
                'pengguna',
                DB::raw('SUM(hm) AS total_hm')
            ])
            ->where('tgl', '>=', DB::raw("date_trunc('month', CURRENT_DATE - INTERVAL '1 month')"))
            ->where('tgl', '<', DB::raw("date_trunc('month', CURRENT_DATE)"))
            ->groupBy('id','tgl', 'no_unit', 'pengguna')
            ->orderBy('tgl', 'desc')
            ->get();

        return view('lho.input', compact('results'));
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

        Excel::import(new LhoinputImport, $request->file('file'));

        return redirect()->route('lhounit.index')->with('success', 'Data berhasil diupload.');
    }
}
