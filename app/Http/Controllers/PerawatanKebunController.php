<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PerawatanKebun;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PerawatanKebunExport;
use App\Imports\PerawatanKebunImport;
use App\Exports\PerawatanKebunPdfExport;
use Yajra\DataTables\Facades\DataTables;

class PerawatanKebunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('vrawatkebun.index');
    }

    public function data(Request $request)
    {
        $query = PerawatanKebun::select([
            'id',
            'tanggal',
            'jenis_perawatan',
            'blok',
            'tahun_tanam',
            'divisi',
            'estate',
            'lahan',
            'hasil',
            'satuan',
            'jml_tenaga',
            'material_1',
            'jumlah_1',
            'satuan_1',
            'material_2',
            'jumlah_2',
            'satuan_2',
            'material_3',
            'jumlah_3',
            'satuan_3',
            'keterangan'
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
            ->addColumn('aksi', function ($row) {
                return '
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditRawatKebun"><i class="fa fa-edit"></i></a>
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
            $rawatkebun = PerawatanKebun::findOrFail($id);
            return response()->json($rawatkebun);
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
                'tanggal' => 'required|date',
                'jenis_perawatan' => 'required|string|max:255',
                'blok' => 'required|string|max:5',
                'tahun_tanam' => 'required|integer',
                'divisi' => 'required|string|max:5',
                'estate' => 'required|string|max:15',
                'lahan' => 'required|string|max:5',
                'hasil' => 'required|numeric',
                'satuan' => 'required|string|max:5',
                'jml_tenaga' => 'required|integer',
                'material_1' => 'nullable|string|max:255',
                'jumlah_1' => 'nullable|numeric',
                'satuan_1' => 'nullable|string|max:5',
                'material_2' => 'nullable|string|max:255',
                'jumlah_2' => 'nullable|numeric',
                'satuan_2' => 'nullable|string|max:5',
                'material_3' => 'nullable|string|max:255',
                'jumlah_3' => 'nullable|numeric',
                'satuan_3' => 'nullable|string|max:5',
                'keterangan' => 'nullable|string|max:255'
            ]);

            $rawatkebun = PerawatanKebun::findOrFail($id);
            $rawatkebun->update($request->all());

            return response()->json(['success' => 'Data berhasil diperbarui.']);
        } catch (\Exception $e) {
            Log::error('Error updating PemupukanKebun: ' . $e->getMessage());
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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        Excel::import( new PerawatanKebunImport, $request->file('file'));

        return redirect()->route('rawatkebun.index')->with('success', 'Data berhasil diupload.');
    }

     public function exportExcel(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');

        return Excel::download(new PerawatanKebunExport($minDate, $maxDate), 'perawatan_kebun.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');

        $pdfExport = new PerawatanKebunPdfExport($minDate, $maxDate);
        return $pdfExport->generatePdf();
    }
}
