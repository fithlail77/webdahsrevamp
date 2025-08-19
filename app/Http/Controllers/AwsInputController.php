<?php

namespace App\Http\Controllers;

use App\Imports\AwsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Aws;

class AwsInputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $thirtyDaysAgo = now()->subDays(30)->format('Y-m-d');

        $awsinput = Aws::select(
            'id',
            'date',
            DB::raw('avg(temp) as temp'),
            DB::raw('avg(humid) as hum'),
            DB::raw('avg(sol_rad) as solrad'),
            DB::raw('avg(rainfall) as hujan'),
            DB::raw('avg(air_pres) as air_pres'),
            DB::raw('avg(wind_speed) as wind_speed'),
            DB::raw('avg(wind_dir) as wind_dir'),
            DB::raw('avg(et) as et'),
            DB::raw('avg(sunshine) as sunshine'),
            DB::raw('avg(index_uv) as uv')
        )
        ->where('date', '>=', $thirtyDaysAgo)
        ->groupBy('date','id')
        ->orderBy('date', 'desc')
        ->get();

        return view('aws.index', compact('awsinput'));
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

        Excel::import(new AwsImport, $request->file('file'));

        return redirect()->route('awsinput.index')->with('success', 'Data berhasil diupload.');
    }
}
