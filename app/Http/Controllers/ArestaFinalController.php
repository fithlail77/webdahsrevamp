<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aresta;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\ArestaFinalExport;
use App\Exports\ArestaFinalExportPdf;
use Maatwebsite\Excel\Facades\Excel;

class ArestaFinalController extends Controller
{
    public function index()
    {
        return view('varestafinal.index');
    }

    public function data(Request $request)
    {
            $query = Aresta::select([
                'id',
                'estate',
                'divisi',
                'blok',
                'lahan',
                'tahun_tanam',
                'bibit',
                'topografi',
                'jenis_tanah',
                'status',
                'jml_pokok',
                'luas',
                'sph',
            ])
                ->orderBy('id', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    return '
                        <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditArestaFinal"><i class="fa fa-edit"></i></a>
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
        $aresta = Aresta::findOrFail($id);
        return response()->json($aresta);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'estate' => 'required|string|max:30',
            'divisi' => 'required|string|max:5',
            'blok' => 'required|string|max:5',
            'lahan' => 'required|string|max:15',
            'tahun_tanam' => 'required|integer',
            'bibit' => 'required|string|max:30',
            'topografi' => 'required|string|max:30',
            'jenis_tanah' => 'required|string|max:30',
            'status' => 'required|string|max:30',
            'jml_pokok' => 'required|integer',
            'luas' => 'required|numeric',
            'sph' => 'required|numeric',
        ]);

        $aresta = Aresta::findOrFail($id);
        $aresta->update($request->all());

        return response()->json(['success' => 'Data berhasil diperbarui.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new ArestaFinalExport(), 'aresat_final.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $pdfexport = new ArestaFinalExportPdf();
        return $pdfexport->generatePdf();
    }
}
