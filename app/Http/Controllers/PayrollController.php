<?php

namespace App\Http\Controllers;

use App\Exports\PayrollExport;
use App\Exports\PayrollPdfExport;
use App\Imports\PayrollImport;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {       
        return view('payroll.index');
    }

    public function data(Request $request)
    {
        $query = Payroll::select([
        'id',
        'estate',
        'tanggal',
        'periode',
        'tahun',
        'divisi',
        'nik',
        'nama',
        'status',
        'pembayaran',
        'blok',
        'tahun_tanam',
        'jenis_pekerjaan',
        'divisi_2',
        'kelompok',
        'coa',
        'ket',
        't_rp',
        'jjg',
        'hasil',
        'sat',
        'hasil_2',
        'sat_21',
        'total',
        'jenis_pupuk',
        'jm_1',
        'qty_1',
        'sat_1',
        'jm_2',
        'qty_2',
        'sat_2',
        'jm_3',
        'qty_3',
        'sat_3',
        'nik_mandor',
        'nama_mandor',
        'hk',
        'hk1',
    ])->orderBy('tanggal', 'desc');

    if (!empty($request->input('search.value'))) {
        // biarkan tanpa filter tanggal
    } else {
        if($request->minDate && $request->maxDate) {
            $query->whereBetween('tanggal', [$request->minDate, $request->maxDate]);
        } elseif ($request->minDate) {
            $query->whereDate('tanggal', '>=', $request->minDate);
        } elseif ($request->maxDate) {
            $query->whereDate('tanggal', '<=', $request->maxDate);
        } else {
            $query->where('tanggal', '>=', Carbon::now()->subDays(30));
        }
    }

    return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('tanggal_formatted', function ($row) {
            return $row->tanggal
                ? Carbon::parse($row->tanggal)->format('d-m-Y')
                : '-';
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
        //
    }

    public function import(request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        Excel::import(new PayrollImport, $request->file('file'));

        //dd($request);
        return redirect()->route('payroll.index')->with('success', 'Data berhasil diupload.');
    }

    public function exportExcel(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $search = $request->input('search');

        return Excel::download(new PayrollExport($minDate, $maxDate, $search), 'Payroll.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $search = $request->input('search');

        $pdfExport = new PayrollPdfExport($minDate, $maxDate, $search);
        return $pdfExport->generatePdf();
    }
}
