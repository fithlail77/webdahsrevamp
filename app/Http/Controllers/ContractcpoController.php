<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Contractcpo;
use Illuminate\Http\Request;
use App\Exports\ContrackCpoExport;
use App\Imports\ContractcpoImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContrackCpoPdfExport;
use Yajra\DataTables\Facades\DataTables;

class ContractcpoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
                $query->whereBetween('real_loading_tk', [$request->minDate, $request->maxDate]);
            } elseif ($request->minDate) {
                $query->whereDate('real_loading_tk', '>=', $request->minDate);
            } elseif ($request->maxDate) {
                $query->whereDate('real_loading_tk', '<=', $request->maxDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('real_loading_tk', '>=', Carbon::now()->subDays(30));
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
    public function simpan(Request $request)
    {
        $request->validate([
            'ggu_sc' => 'required|string',
            'gum_sc' => 'required|integer',
            'plan_loading_tk' => 'required|date',
            'real_loading_tk' => 'required|date',
            'tgl_ba_loading_tk' => 'required|date',
            'tgl_pricing' => 'required|date',
            'real_price' => 'required|numeric',
            'nilai_penjualan' => 'required|numeric',
            'kontrak_qty_ton' => 'required|numeric',
            'real_qty_kg' => 'required|numeric',
            'kapal_tongkang' => 'required|string',
            'suhu' => 'required|numeric',
            'buyer' => 'required|string',
            'status' => 'required|string',
            'lama_loading_hari' => 'required|integer',
        ]);

        // =========================
        // Hitung tanggal real loading
        // =========================
        $tanggalRencana = Carbon::parse($request->plan_loading_tk);
        $tanggalReal = $tanggalRencana
            ->copy()
            ->addDays($request->lama_loading_hari - 1);
        
        // =========================
        // Set periode bulan otomatis
        // (tanggal terakhir bulan berjalan)
        // =========================
        $periodeBulan = Carbon::now()->endOfMonth();

        // =========================
        // Nama bulan otomatis (Jan, Feb, dst)
        // =========================
        Carbon::setLocale('id');
        $bulan = Carbon::now()->translatedFormat('M');

        // Simpan data ke database
        Contractcpo::create([
            'ggu_sc' => $request->ggu_sc,
            'gum_sc' => $request->gum_sc,
            'plan_loading_tk' => $request->plan_loading_tk,
            'real_loading_tk' => $request->real_loading_tk,
            'tgl_ba_loading_tk' => $request->tgl_ba_loading_tk,
            'tgl_pricing' => $request->tgl_pricing,
            'real_price' => $request->real_price,
            'nilai_penjualan' => $request->nilai_penjualan,
            'kontrak_qty_ton' => $request->kontrak_qty_ton,
            'real_qty_kg' => $request->real_qty_kg,
            'kapal_tongkang' => $request->kapal_tongkang,
            'suhu' => $request->suhu,
            'buyer' => $request->buyer,
            'status' => $request->status,
            'lama_loading_hari' => $request->lama_loading_hari,
            'real_loading' => $tanggalReal->format('Y-m-d'),
            'bulan' => $periodeBulan->format('Y-m-d'),
            'bln_name' => $bulan,
            'plan_bln_name' => $bulan,
        ]);

        return redirect()->route('contractcpo.index')->with('success', 'Data berhasil disimpan.');
       
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
            $contractcpo = Contractcpo::findOrFail($id);
            return response()->json($contractcpo);
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
                'ggu_sc' => 'required|string',
                'gum_sc' => 'required|integer',
                'plan_loading_tk' => 'required|date',
                'real_loading_tk' => 'required|date',
                'tgl_ba_loading_tk' => 'required|date',
                'tgl_pricing' => 'required|date',
                'real_price' => 'required|numeric',
                'nilai_penjualan' => 'required|numeric',
                'kontrak_qty_ton' => 'required|numeric',
                'real_qty_kg' => 'required|numeric',
                'kapal_tongkang' => 'required|string',
                'suhu' => 'required|numeric',
                'buyer' => 'required|string',
                'status' => 'required|string',
                'lama_loading_hari' => 'required|integer',
            ]);

            $contractcpo = Contractcpo::findOrFail($id);
            $contractcpo->update($request->all());

            return response()->json(['success' => 'Data berhasil diperbarui.']);
        } catch (\Exception $e) {
            Log::error('Error updating contrack cpo Data ' . $e->getMessage());
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

    public function import(request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        Excel::import(new ContractcpoImport, $request->file('file'));

        return redirect()->route('contractcpo.index')->with('success', 'Data berhasil diupload.');
    }

    public function exportExcel(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $search = $request->input('search');

        return Excel::download(new ContrackCpoExport($minDate, $maxDate, $search), 'Contract_CPO_Data.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $search = $request->input('search');

        $pdfExport = new ContrackCpoPdfExport($minDate, $maxDate, $search);
        return $pdfExport->generatePdf();
    }
}
