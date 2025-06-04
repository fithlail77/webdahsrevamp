<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Panen;

class PanenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $panen = Panen::where('tanggal', '>=', Carbon::now()->subDays(30))
            ->orderBy('tanggal', 'desc')
            ->get();
        return view('panen.index', compact('panen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panen.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'panen.*.tanggal' => 'required|date',
            'panen.*.jenispekerjaan' => 'required|string',
            'panen.*.blok' => 'required|string',
            'panen.*.tt' => 'required|numeric',
            'panen.*.divisi' => 'required|numeric',
            'panen.*.estate' => 'required|string',
            'panen.*.hasilpanen' => 'required|numeric',
            'panen.*.satuan' => 'required|string',
            'panen.*.jmltk' => 'required|numeric',
            'panen.*.hapanen' => 'required|numeric',
        ]);

        foreach ($request->panen as $row) {
            Panen::create([
                'tanggal' => $row['tanggal'],
                'jenispekerjaan' => $row['jenispekerjaan'],
                'blok' => $row['blok'],
                'tt' => $row['tt'],
                'divisi' => $row['divisi'],
                'estate' => $row['estate'],
                'hasilpanen' => $row['hasilpanen'],
                'satuan' => $row['satuan'],
                'jmltk' => $row['jmltk'],
                'hapanen' => $row['hapanen'], 
            ]);
        }

        return redirect()->route('panen.index')->with('success', 'Data berhasil ditambahkan.');
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
        $panen = Panen::findOrFail($id);
        return view('panen.edit', ['Panen' => $panen]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $panen = Panen::findOrFail($id);
        $panen->tanggal = $request->get('tanggal');
        $panen->jenispekerjaan = $request->get('jenispekerjaan');
        $panen->blok = $request->get('blok');
        $panen->tt = $request->get('tt');
        $panen->divisi = $request->get('divisi');
        $panen->estate = $request->get('estate');
        $panen->hasilpanen = $request->get('hasilpanen');
        $panen->satuan = $request->get('satuan');
        $panen->jmltk = $request->get('tk');
        $panen->hapanen = $request->get('ha');
        $panen->save();

        return redirect()->route('panen.index')->with('success', 'Data Berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $panen = Panen::findOrFail($id);
        $panen->delete();
        return redirect()->route('panen.index')->with('success', 'Data berhasil dihapus.');
    }
}
