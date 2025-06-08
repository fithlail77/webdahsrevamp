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

        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        // Generate semua tanggal dalam bulan
        $tanggalLengkap = [];
        $current = $start->copy();
        while ($current <= $end) {
            $tanggalLengkap[$current->format('d')] = 0; // default value 0
            $current->addDay();
        }

        $data = DB::table('ffb_internal')
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
        
        $labels = array_keys($tanggalLengkap);
        $data = $result;

        return view('ffbint.index', compact('ffbint','labels', 'data'));
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
