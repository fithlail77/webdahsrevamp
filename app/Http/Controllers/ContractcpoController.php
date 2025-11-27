<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Contractcpo;
use Illuminate\Http\Request;
use App\Imports\ContractcpoImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ContractcpoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$ccpo = Contractcpo::orderBy('real_loading_tk', 'desc')->get();

        //$chart1 = DB::table('contract_cpo')
        //            ->select('real_loading_tk', 'real_price')
        //            ->whereBetween('real_loading_tk', [
        //                DB::raw("DATE_TRUNC('month', CURRENT_DATE - INTERVAL '2 month')"),
        //                DB::raw("DATE_TRUNC('month', CURRENT_DATE) - INTERVAL '1 day'")
        //                ])
        //            ->orderBy('real_loading_tk')
        //            ->get();
        
        //$labels1 = $chart1->pluck('real_loading_tk')->map(fn($date) => Carbon::parse($date)->format('d M Y'))->toArray(); // contoh: "01"
        //$values1 = $chart1->pluck('real_price')->toArray();

        //$chart2 = DB::table('contract_cpo')
        //            ->select('real_loading_tk', 'real_qty_kg')
        //            ->whereBetween('real_loading_tk', [
        //                DB::raw("DATE_TRUNC('month', CURRENT_DATE - INTERVAL '2 month')"),
        //                DB::raw("DATE_TRUNC('month', CURRENT_DATE) - INTERVAL '1 day'")
        //                ])
        //            ->orderBy('real_loading_tk')
        //            ->get();
        
        //$labels2 = $chart2->pluck('real_loading_tk')->map(fn($date) => Carbon::parse($date)->format('d M Y'))->toArray(); // contoh: "01"
        //$values2 = $chart2->pluck('real_qty_kg')->toArray();

        return view('ccpo.index');
    }

    public function data(Request $request)
    {
        $query = Contractcpo::select([
            'id',
            'ggu_sc',
            'gum_sc',
            'plan_loading_tk',
            'real_loading_tk',
            'tgl_ba_loading_tk',
            'tgl_pricing',
            'real_price',
            'nilai_penjualan',
            'kontrak_qty_ton',
            'real_qty_kg',
            'kapal_tongkang',
            'suhu',
            'buyer',
            'status',
            'lama_loading_hari',
            'real_loading',
            'bulan',
            'bln_name',
            'plan_bln_name'
        ])
        ->orderBy('ggu_sc','desc');

        // Jika ada pencarian global, ambil semua data tanpa filter tanggal
        if (!empty($request->input('search.value'))) {
            // Tidak ada filter tanggal, ambil semua
        } else {
            // Jika ada filter tanggal, gunakan itu
            if($request->minDate && $request->maxDate) {
                $query->whereBetween('plan_loading_tk', [$request->minDate, $request->maxDate]);
            } elseif ($request->minDate) {
                $query->whereDate('plan_loading_tk', '>=', $request->minDate);
            } elseif ($request->maxDate) {
                $query->whereDate('plan_loading_tk', '<=', $request->maxDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('plan_loading_tk', '>=', Carbon::now()->subDays(30));
            }
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('tanggal_formatted1', function ($row) {
                return \Carbon\Carbon::parse($row['plan_loading_tk'])->format('d-m-Y');
            })
            ->addColumn('tanggal_formatted2', function ($row) {
                return \Carbon\Carbon::parse($row['real_loading_tk'])->format('d-m-Y');
            })
            ->addColumn('tanggal_formatted3', function ($row) {
                return \Carbon\Carbon::parse($row['tgl_ba_loading_tk'])->format('d-m-Y');
            })
            ->addColumn('tanggal_formatted4', function ($row) {
                return \Carbon\Carbon::parse($row['tgl_pricing'])->format('d-m-Y');
            })
            ->addColumn('tanggal_formatted5', function ($row) {
                return \Carbon\Carbon::parse($row['real_loading'])->format('d-m-Y');
            })
            ->addColumn('tanggal_formatted6', function ($row) {
                return \Carbon\Carbon::parse($row['bulan'])->format('d-m-Y');
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditCcpo"><i class="fa fa-edit"></i></a>
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

        Excel::import(new ContractcpoImport, $request->file('file'));

        return redirect()->route('contractcpo.index')->with('success', 'Data berhasil diupload.');
    }
}
