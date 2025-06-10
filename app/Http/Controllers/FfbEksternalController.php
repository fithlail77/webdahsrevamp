<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ffbeksternal;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FfbeksternalImport;
use Illuminate\Support\Facades\DB;

class FfbEksternalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ffbeks = Ffbeksternal::where('tanggal', '>=', Carbon::now()->subDays(30))
            ->orderBy('tanggal', 'desc')
            ->get();

        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        $tanggalLengkap = [];
        $current = $start->copy();
        while ($current <= $end) {
            $tanggalLengkap[$current->format('d')] = 0; // default value 0
            $current->addDay();
        }

        $data = DB::table('ffb_eksternal')
            ->selectRaw('DATE(tanggal) as tanggal, SUM(ton_bruto) AS netto_awal')
            ->whereBetween('tanggal', [$start, $end])
            ->groupByRaw('DATE(tanggal)')
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::parse($item->tanggal)->format('d') => (int) $item->netto_awal];
                    })
            ->toArray();
        
        $result = [];
            foreach ($tanggalLengkap as $tgl => $value) {
                $result[] = $data[$tgl] ?? 0;
        }
        
        $labels1 = array_keys($tanggalLengkap);
        $data = $result;

        return view('ffbeks.index', compact('ffbeks','labels1','data'));
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
        $ffbeks = Ffbeksternal::findOrFail($id);
        $ffbeks->delete();
        return redirect()->route('ffbeksternal.index')->with('success', 'Data berhasil dihapus.');
    }

    public function import(request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        Excel::import(new FfbeksternalImport, $request->file('file'));

        return redirect()->route('ffbeksternal.index')->with('success', 'Data berhasil diupload.');
    }
}
