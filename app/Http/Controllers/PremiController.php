<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Premi;
use App\Exports\PremiExport;
use App\Imports\PremiImport;
use Illuminate\Http\Request;
use App\Exports\PremiPdfExport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PremiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('vpremi.index');
    }

    public function data(Request $request)
    {
        $query = Premi::select([
            'id',
            'tanggal',
            'no_kab',
            'nama_kab',
            'nik',
            'nama_karyawan',
            'estate',
            'hmkm_awal',
            'hmkm_akhir',
            'total_hmkm',
            'lokasi',
            'divisi',
            'jenis_pekerjaan',
            'tarif_satuan',
            'hasil_1',
            'satuan_1',
            'hasil_2',
            'satuan_2',
            'total_premi'
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
                return Carbon::parse($row['tanggal'])->format('d-m-Y');
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditPremi"><i class="fa fa-edit"></i></a>
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
            $premi = Premi::findOrFail($id);
            return response()->json($premi);
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
            'no_kab' => 'required|string|max:100',
            'nama_kab' => 'required|string|max:100',
            'nik' => 'required|string|max:15',
            'nama_karyawan' => 'required|string|max:255',
            'estate' => 'required|string|max:30',
            'hmkm_awal' => 'required|integer',
            'hmkm_akhir' => 'required|integer',
            'total_hmkm' => 'required|integer',
            'lokasi' => 'required|string|max:100',
            'divisi' => 'required|string|max:10',
            'jenis_pekerjaan' => 'required|string|max:255',
            'tarif_satuan' => 'required|numeric',
            'hasil_1' => 'required|numeric',
            'satuan_1' => 'required|string|max:10',
            'hasil_2' => 'required|numeric',
            'satuan_2' => 'required|string|max:10',
            'total_premi' => 'required|numeric',
        ]);

        $premi = Premi::findOrFail($id);
        $premi->update($request->all());

        return response()->json(['success' => 'Data berhasil diperbarui.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        Excel::import( new PremiImport, $request->file('file'));

        return redirect()->route('premi.index')->with('success', 'Data berhasil diupload.');
    }

    public function exportExcel(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');

        return Excel::download(new PremiExport($minDate, $maxDate), 'premi.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');

        $pdfExport = new PremiPdfExport($minDate, $maxDate);
        return $pdfExport->generatePdf();
    }
}
