<?php

namespace App\Http\Controllers;

use App\Models\LhoDepre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LhodepreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lhodepre = LhoDepre::select(
            'no_unit',
            'nama_unit',
            'cap_on',
            'aset_desc',
            'acq_val',
            'depre',
            DB::raw('(acq_val + depre) AS penyusutan')
        )
        ->whereRaw("bulan >= date_trunc('month', CURRENT_DATE - INTERVAL '1 month')")
        ->whereRaw("bulan < date_trunc('month', CURRENT_DATE)")
        ->where('no_unit', '!=', '0')
        ->where('nama_unit', '!=', '0')
        ->orderBy('bulan', 'desc')
        ->get();
        
        return view('depre.index', compact('lhodepre'));
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
}
