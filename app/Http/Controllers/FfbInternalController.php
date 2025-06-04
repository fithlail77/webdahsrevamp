<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ffbinternal;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FfbinternalImport;
use Illuminate\Support\Facades\DB;

class FfbInternalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ffbint = Ffbinternal::where('tanggal', '>=', Carbon::now()->subDays(30))
        ->orderBy('tanggal', 'desc')
        ->get();

        $chart1 = DB::table('ffb_internal')
            ->select('tanggal', DB::raw('SUM(ton_bruto) AS netto_awal'))
            ->whereBetween('tanggal', [
                Carbon::now()->startOfMonth()->toDateString(),
                Carbon::now()->endOfMonth()->toDateString()
            ])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();
        
        $labels1 = $chart1->pluck('tanggal')->map(fn($date) => Carbon::parse($date)->format('d'))->toArray(); // contoh: "01 Jun"
        $values1 = $chart1->pluck('netto_awal')->toArray();

        return view('ffbint.index', compact('ffbint','labels1', 'values1'));
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
        $ffbint = Ffbinternal::findOrFail($id);
        $ffbint->delete();
        return redirect()->route('ffbinternal.index')->with('success', 'Data berhasil dihapus.');
    }

    public function import(request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        Excel::import(new FfbinternalImport, $request->file('file'));

        return redirect()->route('ffbinternal.index')->with('success', 'Data berhasil diupload.');
    }
}
