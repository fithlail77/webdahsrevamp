<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Contractpk;
use Illuminate\Http\Request;
use App\Exports\ContractPkExport;
use App\Imports\ContractpkImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exports\ContractPkPdfExport;
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
    public function simpan(Request $request)
    {
        $request->validate([
            'ltc' => 'nullable|numeric',
            'nomor_sc' => 'required|numeric',
            'date_pricing' => 'required|date',
            'price' => 'required|numeric',
            'dicount_ggu' => 'required|numeric',
            'real_price' => 'required|numeric',
            'dp_date' => 'nullable|date',
            'rencana_awal_kirim' => 'nullable|date',
            'rencana_closed_kirim' => 'nullable|date',
            'actual_awal_kirim' => 'required|date',
            'actual_closed_kirim' => 'required|date',
            'qty_kontrak_kg' => 'required|numeric',
            'buyer' => 'required|string',
            'status' => 'required|string',
            'real_qty_kg' => 'required|numeric',
            'buyer_received_qty_kg' => 'required|numeric',
            'rp' => 'required|numeric',
            'keterangan' => 'nullable|string'
        ]);

        // =========================
        // Nama bulan otomatis (Januari, Februari, dst)
        // =========================
        Carbon::setLocale('id');
        $bulan = Carbon::now()->translatedFormat('F');

        // =========================
        // Set periode bulan otomatis
        // (tanggal terakhir bulan berjalan)
        // =========================
        $periodeBulan = Carbon::now()->endOfMonth();

        Contractpk::create([
            'ltc' => $request->ltc,
            'nomor_sc' => $request->nomor_sc,
            'bln_name' => $bulan,
            'date_pricing' => $request->date_pricing,
            'price' => $request->price,
            'dicount_ggu' => $request->dicount_ggu,
            'real_price' => $request->real_price,
            'dp_date' => $request->dp_date,
            'rencana_awal_kirim' => $request->rencana_awal_kirim,
            'rencana_closed_kirim' => $request->rencana_closed_kirim,
            'actual_awal_kirim' => $request->actual_awal_kirim,
            'actual_closed_kirim' => $request->actual_closed_kirim,
            'qty_kontrak_kg' => $request->qty_kontrak_kg,
            'buyer' => $request->buyer,
            'status' => $request->status,
            'real_qty_kg' => $request->real_qty_kg,
            'buyer_received_qty_kg' => $request->buyer_received_qty_kg,
            'rp' => $request->rp,
            'keterangan' => $request->keterangan,
            'bulan' => $periodeBulan
        ]);

        return redirect()->route('contractpk.index')->with('success', 'Data berhasil disimpan.');
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
            $contractpk = Contractpk::findOrFail($id);
            return response()->json($contractpk);
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
                'ltc' => 'nullable|numeric',
                'nomor_sc' => 'required|numeric',
                'date_pricing' => 'required|date',
                'price' => 'required|numeric',
                'dicount_ggu' => 'required|numeric',
                'real_price' => 'required|numeric',
                'dp_date' => 'nullable|date',
                'rencana_awal_kirim' => 'nullable|date',
                'rencana_closed_kirim' => 'nullable|date',
                'actual_awal_kirim' => 'required|date',
                'actual_closed_kirim' => 'required|date',
                'qty_kontrak_kg' => 'required|numeric',
                'buyer' => 'required|string',
                'status' => 'required|string',
                'real_qty_kg' => 'required|numeric',
                'buyer_received_qty_kg' => 'required|numeric',
                'rp' => 'required|numeric',
                'keterangan' => 'nullable|string'
            ]);

            $contractpk = Contractpk::findOrFail($id);
            $contractpk->update($request->all());

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

        Excel::import(new ContractpkImport, $request->file('file'));

        return redirect()->route('contractpk.index')->with('success', 'Data berhasil diupload.');
    }

    public function exportExcel(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $search = $request->input('search');

        return Excel::download(new ContractPkExport($minDate, $maxDate, $search), 'Contract_PK_Data.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $search = $request->input('search');

        $pdfExport = new ContractPkPdfExport($minDate, $maxDate, $search);
        return $pdfExport->generatePdf();
    }
}
