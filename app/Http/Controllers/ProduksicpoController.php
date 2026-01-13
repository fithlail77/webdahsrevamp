<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\Produksicpo;
use Illuminate\Http\Request;
use App\Exports\ProduksiCpoExport;
use App\Imports\ProduksicpoImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProduksiCpoPdfExport;
use Yajra\DataTables\Facades\DataTables;

class ProduksicpoController extends Controller
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
            
        return view('cpo.index', compact('estate','divisi'));
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
             // FORMAT OER AFTER GRADING → PERSEN 2 DESIMAL
            ->editColumn('oer_after_grading', function ($row) {
                if ($row->oer_after_grading === null) {
                    return '-';
                }
                return number_format($row->oer_after_grading * 100, 2) . '%';
            })
            // FORMAT KER AFTER GRADING → PERSEN 2 DESIMAL
            ->editColumn('ker_after_grading', function ($row) {
                if ($row->ker_after_grading === null) {
                    return '-';
                }
                return number_format($row->ker_after_grading * 100, 2) . '%';
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
        try {
            $produksicpo = Produksicpo::findOrFail($id);
            return response()->json($produksicpo);
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
        $request->validate([
            'tanggal' => 'required|date',
            'tbs_terima_internal' => 'nullable|numeric',
            'persen_terima_internal' => 'nullable|numeric',
            'tbs_terima_eksternal' => 'nullable|numeric',
            'persen_terima_eksternal' => 'nullable|numeric',
            'total_tbs_terima' => 'nullable|numeric',
            'tbs_olah' => 'nullable|numeric',
            'sisa' => 'nullable|numeric',
            'cpo_produksi_today' => 'nullable|numeric',
            'cpo_produksi_todate' => 'nullable|numeric',
            'kernel_produksi' => 'nullable|numeric',
            'oer' => 'nullable|numeric',
            'ker' => 'nullable|numeric',
            'oil_loss' => 'nullable|numeric',
            'kernel_loss' => 'nullable|numeric',
            'stok_cpo_pks_1' => 'nullable|numeric',
            'stok_cpo_pks_2' => 'nullable|numeric',
            'stok_cpo_jetty_1' => 'nullable|numeric',
            'stok_cpo_jetty_2' => 'nullable|numeric',
            'cpo_despatch_jetty' => 'nullable|numeric',
            'cpo_despatch_tongkang' => 'nullable|numeric',
            'stock_nut_produksi' => 'nullable|numeric',
            'stok_kernel_sistem_proses_silo_1' => 'nullable|numeric',
            'stok_kernel_sistem_proses_silo_2' => 'nullable|numeric',
            'stok_kernel_gudang' => 'nullable|numeric',
            'stok_kernel_st_kernel' => 'nullable|numeric',
            'stok_kernel_depan_workshop' => 'nullable|numeric',
            'stok_kernel_st_despatch' => 'nullable|numeric',
            'stok_kernel_bulking_silo' => 'nullable|numeric',
            'stok_kernel_total' => 'nullable|numeric',
            'despatch_kernel' => 'nullable|numeric',
            'stok_cangkang' => 'nullable|numeric',
            'tbs_olah_netto' => 'nullable|numeric',
            'oer_after_grading' => 'nullable|numeric',
            'ker_after_grading' => 'nullable|numeric',
        ]);

        try {
            $produksicpo = Produksicpo::findOrFail($id);
            $produksicpo->update($request->all());
            return response()->json(['success' => 'Data berhasil diperbarui.']);
        } catch (\Exception $e) {
            Log::error('Error in update Method: ' . $e->getMessage() . ' ID: ' . $id);
            return response()->json(['error' => 'Gagal memperbarui data: ' . $e->getMessage()], 500);
        }
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
