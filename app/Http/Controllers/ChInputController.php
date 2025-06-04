<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChInput;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ChImport;
use Carbon\Carbon;

class ChInputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ChInput = ChInput::where('dates', '>=', Carbon::now()->subDays(30))
            ->where('pt', 'GUM')
            ->orderBy('dates', 'desc')
            ->get();

        $chart1 = DB::table('curah_hujan')
            ->select('dates', DB::raw('ROUND(AVG(ch), 2) AS avg_ch'))
            ->where('pt', 'GUM')
            ->whereBetween('dates', [
                Carbon::now()->startOfMonth()->toDateString(),
                Carbon::now()->endOfMonth()->toDateString()
            ])
            ->groupBy('dates')
            ->orderBy('dates')
            ->get();

        $labels1 = $chart1->pluck('dates')->map(fn($date) => Carbon::parse($date)->format('d M'))->toArray(); // contoh: "01 Jun"
        $values1 = $chart1->pluck('avg_ch')->toArray();


        return view('ch.index', compact('ChInput', 'labels1', 'values1'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ch.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'ChInput.*.pt' => 'required|string',
            'ChInput.*.dates' => 'required|date',
            'ChInput.*.estate' => 'required|string',
            'ChInput.*.divisi' => 'required|string',
            'ChInput.*.ch' => 'required|numeric',
        ]);

        foreach ($request->ChInput as $row) {
            ChInput::create([
                'pt' => $row['pt'],
                'dates' => $row['dates'],
                'estate' => $row['estate'],
                'divisi' => $row['divisi'], 
                'ch' => $row['ch'],
            ]);
        }

        return redirect()->route('curah.index')->with('success', 'Data berhasil ditambahkan.');
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
        $ChInput = ChInput::findOrFail($id);
        return view('ch.edit', ['ChInput' => $ChInput]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ChInput_update = ChInput::findOrFail($id);
        $ChInput_update->pt = $request->get('pt');
        $ChInput_update->dates = $request->get('dates');
        $ChInput_update->estate = $request->get('estate');
        $ChInput_update->divisi = $request->get('divisi');
        $ChInput_update->ch = $request->get('ch');
        $ChInput_update->save();

        return redirect()->route('curah.index')->with('success', 'Data Berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $chInput = ChInput::findOrFail($id);
        $chInput->delete();
        return redirect()->route('curah.index')->with('success', 'Data berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        Excel::import(new ChImport, $request->file('file'));

        return redirect()->route('curah.index')->with('success', 'Data berhasil diupload.');
    }
}
