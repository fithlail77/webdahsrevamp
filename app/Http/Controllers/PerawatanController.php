<?php

namespace App\Http\Controllers;

use App\Exports\PerawatanExport;
use App\Exports\PerawatanPdfExport;
use App\Imports\PerawatanImport;
use App\Models\Perawatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PerawatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('rawat.index');
    }

    public function data(Request $request)
    {
        $query = Perawatan::select([
            'id',
            'tanggal',
            'bulan',
            'tahun_jalan',
            'tahun',
            'nik',
            'nama',
            'status',
            'pembayaran',
            'blok',
            'tt',
            'kelompok',
            'coa',
            'ket',
            'tarif_rp',
            'bjr',
            'hasil',
            'sat',
            'hasil_2',
            'sat_2',
            'total',
            'periode',
            'period_txt',
            'tahun_period',
            'estate',
            'divisi',
            'jenis_pekerjaan',
            'areal',
            'keterangan',
            'sph',
            'ha',
            'hk',
        ])
        ->orderBy('tanggal', 'desc');

        // Jika ada pencarian global, ambil semua data tanpa filter tanggal
        if (!empty($request->input('search.value'))) {
            // Tidak ada filter tanggal, ambil semua
        } else {
            // Jika ada filter tanggal, gunakan itu
            if($request->minDate && $request->maxDate) {
                $query->whereBetween('tanggal', [$request->minDate, $request->maxDate]);
            } elseif ($request->minDate) {
                $query->whereDate('tanggal', '>=', $request->minDate);
            } elseif ($request->maxDate) {
                $query->whereDate('tanggal', '<=', $request->maxDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('tanggal', '>=', Carbon::now()->subDays(30));
            }
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('tanggal_formatted', function ($row) {
                return \Carbon\Carbon::parse($row['tanggal'])->format('d-m-Y');
            })
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
        $rawat = Perawatan::findOrFail($id);
        $rawat->delete();
        return redirect()->route('perawatan.index')->with('success', 'Data berhasil dihapus.');
    }

    public function import(request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        Excel::import(new PerawatanImport, $request->file('file'));

        return redirect()->route('perawatan.index')->with('success', 'Data berhasil diupload.');
    }

    public function exportExcel(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $search = $request->input('search');

        return Excel::download(new PerawatanExport($minDate, $maxDate, $search), 'Perawatan.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $search = $request->input('search');

        $pdfExport = new PerawatanPdfExport($minDate, $maxDate, $search);
        return $pdfExport->generatePdf();
    }
}
