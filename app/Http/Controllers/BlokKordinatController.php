<?php

namespace App\Http\Controllers;

use App\Imports\BlokKordinatImport;
use App\Models\BlokKordinat;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class BlokKordinatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('vblok.index');
    }

    public function data(Request $request)
    {
        $query = BlokKordinat::select([
            'id',
            'estate',
            'divisi',
            'blok',
            'x',
            'y',
            'l1',
            'l2',
            'poly_id'
        ])
        ->orderBy('estate','desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return '
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditBlokKordinat"><i class="fa fa-edit"></i></a>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vblok.input');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $blokkordinat = $request->input('blokkordinat');

        foreach ($blokkordinat as $data) {
            BlokKordinat::create([
                'estate' => $data['estate'],
                'divisi' => $data['divisi'],
                'blok' => $data['blok'],
                'x' => $data['x'],
                'y' => $data['y'],
                'l1' => $data['l1'],
                'l2' => $data['l2'],
                'poly_id' => $data['poly_id'],
            ]);
        }

        return response()->json(['message' => 'Data berhasil disimpan.']);
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
        $blokKordinat = BlokKordinat::findOrFail($id);
        return response()->json($blokKordinat);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'estate' => 'required|string',
            'divisi' => 'required|string',
            'blok' => 'required|string',
            'x' => 'required|numeric',
            'y' => 'required|numeric',
            'l1' => 'required|numeric',
            'l2' => 'required|numeric',
            'poly_id' => 'required|integer',
        ]);

        $blokKordinat = BlokKordinat::findOrFail($id);
        $blokKordinat->update($request->all());

        return response()->json(['success' => 'Data berhasil diperbarui.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        Excel::import( new BlokKordinatImport, $request->file('file'));

        return redirect()->route('blokkoordinat.index')->with('success', 'Data berhasil diupload.');
    }
}
