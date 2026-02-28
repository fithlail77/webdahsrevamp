<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\Pupukrawat;
use App\Exports\PupukExport;
use App\Imports\PupukImport;
use Illuminate\Http\Request;
use App\Exports\PupukPdfExport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PupukrawatinputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estate = Company::select('estate')
            ->distinct()
            ->get();

        $divisi = Company::select('divisi')
            ->distinct()
            ->orderBy('divisi','asc')
            ->get();
        
        return view('pupuk.index', compact('estate','divisi'));
    }

    public function data(Request $request)
    {
        $query = Pupukrawat::select([
            'id',
            'issue_no',
            'material_code',
            'material_name',
            'unit',
            'issue_qty',
            'issue_date',
            'posting_date',
            'storage_location',
            'description',
            'estate',
            'div',
            'block1',
            'block2',
            'years',
            'tm_tbm',
            'sap_issue_no',
            'kelompok',
            'jenis_pupuk',
            'system_aplikasi',
            'bln',
            'tahun',
            'estate2',
            'divisi',
            'status2',
            'areal',
            'blok',
            'tt',
            'programs',
            'dosis',
            'jumlah_pokok',
            'ha',
            'harga',
            'biaya',
        ])
        ->orderBy('issue_date', 'desc');

        // Jika ada pencarian global, ambil semua data tanpa filter tanggal
        if (!empty($request->input('search.value'))) {
            // Tidak ada filter tanggal, ambil semua
        } else {
            // Jika ada filter tanggal, gunakan itu
            if($request->minDate && $request->maxDate) {
                $query->whereBetween('issue_date', [$request->minDate, $request->maxDate]);
            } elseif ($request->minDate) {
                $query->whereDate('issue_date', '>=', $request->minDate);
            } elseif ($request->maxDate) {
                $query->whereDate('issue_date', '<=', $request->maxDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('issue_date', '>=', Carbon::now()->subDays(30));
            }
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('tanggal_formatted', function ($row) {
                return \Carbon\Carbon::parse($row['issued_date'])->format('d-m-Y');
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
        $pupuk = Pupukrawat::findOrFail($id);
        $pupuk->delete();
        return redirect()->route('pupuk.index')->with('success', 'Data berhasil dihapus.');
    }

    public function import(request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        Excel::import(new PupukImport, $request->file('file'));

        //dd($request);

        return redirect()->route('pupuk.index')->with('success', 'Data berhasil diupload.');
    }

    public function exportExcel(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $search = $request->input('search');

        return Excel::download(new PupukExport($minDate, $maxDate, $search), 'Pupuk.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $search = $request->input('search');

        $pdfExport = new PupukPdfExport($minDate, $maxDate, $search);
        return $pdfExport->generatePdf();
    }
}
