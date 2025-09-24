<?php

namespace App\Http\Controllers;

use App\Exports\PremiExport;
use App\Exports\PremiPdfExport;
use App\Models\Premi;
use App\Imports\PremiImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PremiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('vpremi.index');
    }

    public function data(Request $request)
    {
        $query = Premi::select([
            'id',
            'tanggal',
            'no_kab',
            'nama_kab',
            'nik',
            'nama_karyawan',
            'estate',
            'hmkm_awal',
            'hmkm_akhir',
            'total_hmkm',
            'lokasi',
            'divisi',
            'jenis_pekerjaan',
            'tarif_satuan',
            'hasil_1',
            'satuan_1',
            'hasil_2',
            'satuan_2',
            'total_premi'
        ])
        ->whereDate('tanggal', '>=', now()->subDays(10)->format('Y-m-d'))
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
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditPremi"><i class="fa fa-edit"></i></a>
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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        Excel::import( new PremiImport, $request->file('file'));

        return redirect()->route('premi.index')->with('success', 'Data berhasil diupload.');
    }

    public function exportExcel(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');

        return Excel::download(new PremiExport($minDate, $maxDate), 'premi.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');

        $pdfExport = new PremiPdfExport($minDate, $maxDate);
        return $pdfExport->generatePdf();
    }
}
