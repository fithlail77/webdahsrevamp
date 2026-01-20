<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Contractpk;
use Illuminate\Http\Request;
use App\Imports\ContractpkImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ContractpkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        

        return view('cpk.index');
    }

    public function data(Request $request)
    {
        $query = Contractpk::select([
            'id',
            'ltc',
            'nomor_sc',
            'bln_name',
            'date_pricing',
            'price',
            'dicount_ggu',
            'real_price',
            'dp_date',
            'rencana_awal_kirim',
            'rencana_closed_kirim',
            'actual_awal_kirim',
            'actual_closed_kirim',
            'qty_kontrak_kg',
            'buyer',
            'status',
            'real_qty_kg',
            'buyer_received_qty_kg',
            'rp',
            'keterangan',
            'bulan',
        ])
        ->orderBy('nomor_sc','desc');

        // Jika ada pencarian global, ambil semua data tanpa filter tanggal
        if (!empty($request->input('search.value'))) {
            // Tidak ada filter tanggal, ambil semua
        } else {
            // Jika ada filter tanggal, gunakan itu
            if($request->minDate && $request->maxDate) {
                $query->whereBetween('date_pricing', [$request->minDate, $request->maxDate]);
            } elseif ($request->minDate) {
                $query->whereDate('date_pricing', '>=', $request->minDate);
            } elseif ($request->maxDate) {
                $query->whereDate('date_pricing', '<=', $request->maxDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('date_pricing', '>=', Carbon::now()->subDays(30));
            }
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('tanggal_formatted1', function ($row) {
                return \Carbon\Carbon::parse($row['date_pricing'])->format('d-m-Y');
            })
            ->addColumn('tanggal_formatted2', function ($row) {
                return \Carbon\Carbon::parse($row['actual_awal_kirim'])->format('d-m-Y');
            })
            ->addColumn('tanggal_formatted3', function ($row) {
                return \Carbon\Carbon::parse($row['actual_closed_kirim'])->format('d-m-Y');
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditCpk"><i class="fa fa-edit"></i></a>
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

        Excel::import(new ContractpkImport, $request->file('file'));

        return redirect()->route('contractpk.index')->with('success', 'Data berhasil diupload.');
    }
}
