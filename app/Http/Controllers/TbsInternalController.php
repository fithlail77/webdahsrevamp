<?php

namespace App\Http\Controllers;

use App\Imports\TbsImport;
use App\Models\Tbsinternal;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class TbsInternalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tbsinternal = Tbsinternal::where('tgltiket', '>=', Carbon::now()->subDay(30))
            ->orderBy('tgltiket', 'desc')
            ->get();
        return view('tbsint.index', compact('tbsinternal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tbsint.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(Request $request)
    {
        Tbsinternal::create($request->all());
        return redirect()->route('tbsinternal.index')->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tbsinternal = Tbsinternal::find($id);
        return view('tbsint.detail', compact('tbsinternal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tbsinternal = Tbsinternal::findOrFail($id);
        return view('tbsint.edit', ['Tbsinternal' => $tbsinternal]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tbsinternal = Tbsinternal::findOrFail($id);
        $tbsinternal->angkutan = $request->get('tujuan');
        $tbsinternal->nopol = $request->get('nopol');
        $tbsinternal->supir = $request->get('supir');
        $tbsinternal->estate = $request->get('estate');
        $tbsinternal->divisi = $request->get('divisi');
        $tbsinternal->blok = $request->get('blok');
        $tbsinternal->tt = $request->get('tt');
        $tbsinternal->lahan = $request->get('lahan');
        $tbsinternal->jmltandan = $request->get('jmltandan');
        $tbsinternal->brondolan = $request->get('brondolan');
        $tbsinternal->grading = $request->get('grd');
        $tbsinternal->bjr = $request->get('bjr');
        $tbsinternal->sortase = $request->get('persengrd');
        $tbsinternal->noramp = $request->get('noramp');
        $tbsinternal->jarak = $request->get('jarak');
        $tbsinternal->tarif = $request->get('tarif');
        $tbsinternal->f0 = $request->get('f0');
        $tbsinternal->f00 = $request->get('f00');
        $tbsinternal->f14 = $request->get('f14');
        $tbsinternal->f5 = $request->get('f5');
        $tbsinternal->f6 = $request->get('f6');
        $tbsinternal->tankos = $request->get('tankos');
        $tbsinternal->tkpanjang = $request->get('tkpanjang');
        $tbsinternal->grdbrondolan = $request->get('brondolan1');
        $tbsinternal->sampah = $request->get('sampah');
        $tbsinternal->kastrasi = $request->get('kastrasi');
        $tbsinternal->save();

        return redirect()->route('tbsinternal.index')->with('success', 'Data Berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tbsinternal = Tbsinternal::find($id);
        $tbsinternal->delete();
        return redirect()->route('tbsinternal.index')->with('success', 'Data berhasil dihapus.');
    }

    public function import(request $request)
    {
        Excel::import(new TbsImport(), $request->file('file'));
        return redirect()->route('tbsinternal.index')->with('success', 'Data berhasil diimport.');
    }
}
