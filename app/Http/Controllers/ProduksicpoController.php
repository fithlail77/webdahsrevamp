<?php

namespace App\Http\Controllers;

use App\Exports\ProduksiCpoExport;
use App\Exports\ProduksiCpoPdfExport;
use Carbon\Carbon;
use App\Models\Produksicpo;
use Illuminate\Http\Request;
use App\Imports\ProduksicpoImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProduksicpoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$cpo = Produksicpo::where('tanggal', '>=', Carbon::now()->subDays(30))
        //->orderBy('tanggal', 'desc')
        //->get();

        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        $tanggalLengkap = [];
        $current = $start->copy();
        while ($current <= $end) {
            $tanggalLengkap[$current->format('d')] = 0; // default value 0
            $current->addDay();
        }

        $chart1 = DB::table('produksi_cpo')
            ->selectRaw('DATE(tanggal) as tanggal, cpo_produksi_today')
            ->whereBetween('tanggal', [$start, $end])
            ->orderByRaw('DATE(tanggal)')
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::parse($item->tanggal)->format('d') => (int) $item->cpo_produksi_today];
                    })
            ->toArray();
        
        $result = [];
            foreach ($tanggalLengkap as $tgl => $value) {
                $result[] = $chart1[$tgl] ?? 0;
        }
        
        $labels1 = array_keys($tanggalLengkap);
        $chart1 = $result;

        $chart2 = DB::table('produksi_cpo')
            ->selectRaw('DATE(tanggal) as tanggal, kernel_produksi')
            ->whereBetween('tanggal', [$start, $end])
            ->orderByRaw('DATE(tanggal)')
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::parse($item->tanggal)->format('d') => (int) $item->kernel_produksi];
                    })
            ->toArray();
        
        $result2 = [];
            foreach ($tanggalLengkap as $tgl => $value) {
                $result2[] = $chart2[$tgl] ?? 0;
        }
        
        $chart2 = $result2;

        return view('cpo.index', compact('labels1','chart1','chart2'));
    }

    public function data(Request $request)
    {
        $query = Produksicpo::select([
            'id',
            'tanggal',
            'tbs_terima_internal',
            'persen_terima_internal',
            'tbs_terima_eksternal',
            'persen_terima_eksternal',
            'total_tbs_terima',
            'tbs_olah',
            'sisa',
            'cpo_produksi_today',
            'cpo_produksi_todate',
            'ffa_cpo_today',
            'ffa_cpo_todate',
            'kernel_produksi',
            'oer',
            'ker',
            'oil_loss',
            'kernel_loss',
            'stok_cpo_pks_1',
            'stok_cpo_pks_2',
            'stok_cpo_jetty_1',
            'stok_cpo_jetty_2',
            'cpo_despatch_jetty',
            'cpo_despatch_tongkang',
            'stock_nut_produksi',
            'stok_kernel_sistem_proses_silo_1',
            'stok_kernel_sistem_proses_silo_2',
            'stok_kernel_gudang',
            'stok_kernel_st_kernel',
            'stok_kernel_depan_workshop',
            'stok_kernel_st_despatch',
            'stok_kernel_bulking_silo',
            'stok_kernel_total',
            'despatch_kernel',
            'sisa_produksi_cangkang',
            'stok_cangkang',
            'despatch_cangkang',
            'bulan',
            'tahun',
            'tbs_olah_netto_internal',
            'tbs_olah_netto_eksternal',
            'tbs_olah_netto',
            'oer_after_grading',
            'ker_after_grading',
        ])
        ->orderBy('tanggal','desc');

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
             ->addColumn('tanggal_formatted1', function ($row) {
                return \Carbon\Carbon::parse($row['bulan'])->format('d-m-Y');
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditProduksiCpo"><i class="fa fa-edit"></i></a>
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

        Excel::import(new ProduksicpoImport, $request->file('file'));

        return redirect()->route('produksicpo.index')->with('success', 'Data berhasil diupload.');
    }

    public function exportExcel(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $search = $request->input('search');

        return Excel::download(new ProduksiCpoExport($minDate, $maxDate, $search), 'Produksi_CPO.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $search = $request->input('search');

        $pdfExport = new ProduksiCpoPdfExport($minDate, $maxDate, $search);
        return $pdfExport->generatePdf();
    }
}
