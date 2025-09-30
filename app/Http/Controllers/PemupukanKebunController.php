<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PemupukanKebun;
use App\Exports\PemupukanKebunExport;
use App\Imports\PemupukanKebunImport;
use App\Exports\PemupukanKebunPdfExport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PemupukanKebunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('vpupukebun.index');
    }

    public function data(Request $request)
    {
        $query = PemupukanKebun::select([
            'id',
            'tanggal',
            'jenis_pupuk',
            'blok',
            'tahun_tanam',
            'divisi',
            'estate',
            'lahan',
            'hasil',
            'pokok',
            'dosis',
            'jml_tenaga',
            'keterangan'
        ])
        ->whereDate('tanggal','>=', now()->subDays(30)->format('Y-m-d'))
        ->orderBy('tanggal','desc');

        if($request->minDate && $request->maxDate) {
            $query->whereBetween('tanggal', [$request->minDate, $request->maxDate]);
        } elseif ($request->minDate) {
            $query->whereDate('tanggal', '>=', $request->minDate);
        } elseif ($request->maxDate) {
            $query->whereDate('tanggal', '<=', $request->maxDate);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('tanggal_formatted', function ($row) {
                return \Carbon\Carbon::parse($row['tanggal'])->format('d-m-Y');
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditPupukKebun"><i class="fa fa-edit"></i></a>
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
        try {
            $pupukkebun = PemupukanKebun::findOrFail($id);
            return response()->json($pupukkebun);
        } catch (\Exception $e) {
            Log::error('Error in edit Method: ' . $e->getMessage() . ' ID: ' . $id);
            return response()->json(['error' => 'Data tidak ditemukan: ' . $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'tanggal' => 'required|date',
                'jenis_pupuk' => 'required|string|max:255',
                'blok' => 'required|string|max:10',
                'tahun_tanam' => 'required|integer',
                'divisi' => 'required|string|max:15',
                'estate' => 'required|string|max:30',
                'lahan' => 'required|string|max:255',
                'hasil' => 'required|numeric',
                'pokok' => 'required|integer',
                'dosis' => 'required|numeric',
                'jml_tenaga' => 'required|integer',
                'keterangan' => 'required|string|max:255',
            ]);

            $pupukkebun = PemupukanKebun::findOrFail($id);
            $pupukkebun->update($request->all());

            return response()->json(['success' => 'Data berhasil diperbarui.']);
        } catch (\Exception $e) {
            Log::error('Error updating PemupukanKebun: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
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

        Excel::import( new PemupukanKebunImport, $request->file('file'));

        return redirect()->route('pupukkebun.index')->with('success', 'Data berhasil diupload.');
    }

    public function exportExcel(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');

        return Excel::download(new PemupukanKebunExport($minDate, $maxDate), 'pemupukan_kebun.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');

        $pdfExport = new PemupukanKebunPdfExport($minDate, $maxDate);
        return $pdfExport->generatePdf();
    }
}
