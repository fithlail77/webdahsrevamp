<?php

namespace App\Http\Controllers;

use App\Imports\AwsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Aws;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\AwsExport;
use App\Exports\AwsPdfExport;

class AwsInputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('aws.index');
    }

    public function data(Request $request)
    {
        $query = Aws::select([
            'id',
            'time',
            'date',
            'temp',
            'humid',
            'sol_rad',
            'rainfall',
            'air_pres',
            'wind_speed',
            'wind_dir',
            'et',
            'sunshine',
            'index_uv'
        ])
        ->orderBy('date','desc')
        ->orderBy('time','desc');

        // Jika ada pencarian global, ambil semua data tanpa filter tanggal
        if (!empty($request->input('search.value'))) {
            // Tidak ada filter tanggal, ambil semua
        } else {
            // Jika ada filter tanggal, gunakan itu
            if($request->minDate && $request->maxDate) {
                $query->whereBetween('date', [$request->minDate, $request->maxDate]);
            } elseif ($request->minDate) {
                $query->whereDate('date', '>=', $request->minDate);
            } elseif ($request->maxDate) {
                $query->whereDate('date', '<=', $request->maxDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('date', '>=', Carbon::now()->subDays(30));
            }
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('tanggal_formatted', function ($row) {
                return \Carbon\Carbon::parse($row['date'])->format('d-m-Y');
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditAws"><i class="fa fa-edit"></i></a>
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

    public function import(request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        Excel::import(new AwsImport, $request->file('file'));

        return redirect()->route('awsinput.index')->with('success', 'Data berhasil diupload.');
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(15)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        return Excel::download(new AwsExport($startDate, $endDate), 'aws_data.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(15)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $pdfExport = new AwsPdfExport($startDate, $endDate);
        return $pdfExport->generatePdf();
    }
}
