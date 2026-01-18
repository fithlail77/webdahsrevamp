<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\RealisasiPanen;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RealisasiPanenExport;
use App\Imports\RealisasipanenImport;
use App\Exports\RealisasiPanenPdfExport;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class RealisasiPanenController extends Controller
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

        return view('rpanen.index', compact('estate','divisi'));
    }

    public function data(Request $request)
    {
        $query = RealisasiPanen::select([
            'id',
            'tanggal',
            'jenis_kerja',
            'blok',
            'tt',
            'divisi',
            'estate',
            'hasil',
            'satuan',
            'tk',
            'ha_panen',
        ])
        ->orderBy('tanggal','desc');

        // Filter berdasarkan estate user
        $userEstate = Auth::user()->estate ?? null;
        if ($userEstate && $userEstate !== 'all') {
            $query->where('estate', $userEstate);
        }

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
                $query->where('tanggal', '>=', Carbon::now()->subDays(7));
            }
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('tanggal_formatted', function ($row) {
                return \Carbon\Carbon::parse($row['tanggal'])->format('d-m-Y');
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditRealisasiPanen"><i class="fa fa-edit"></i></a>
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
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_kerja' => 'required|string|max:50',
            'blok' => 'required|string|max:5',
            'tt' => 'required|integer',
            'divisi' => 'required|string|max:5',
            'estate' => 'required|string|max:30',
            'hasil' => 'required|integer',
            'satuan' => 'required|string|max:15',
            'tk' => 'required|integer',
            'ha_panen' => 'required|numeric',
        ]);

        RealisasiPanen::create([
            'tanggal' => $request->tanggal,
            'jenis_kerja' => $request->jenis_kerja,
            'blok' => $request->blok,
            'tt' => $request->tt,
            'divisi' => $request->divisi,
            'estate' => $request->estate,
            'hasil' => $request->hasil,
            'satuan' => $request->satuan,
            'tk' => $request->tk,
            'ha_panen' => $request->ha_panen
        ]);

        return redirect()->route('realisasipanen.index')->with('success', 'Data Realisasi Panen berhasil disimpan.');
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
            $realisasiPanen = RealisasiPanen::findOrFail($id);
            return response()->json($realisasiPanen);
        } catch (\Exception $e) {
            Log::error('Error in edit method: ' . $e->getMessage() . ' ID: ' . $id);
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
            'jenis_kerja' => 'required|string|max:255',
            'blok' => 'required|string|max:255',
            'tt' => 'required|integer',
            'divisi' => 'required|string|max:255',
            'estate' => 'required|string|max:255',
            'hasil' => 'required|numeric',
            'satuan' => 'required|string|max:255',
            'tk' => 'required|integer',
            'ha_panen' => 'required|numeric',
        ]);

        $realisasiPanen = RealisasiPanen::findOrFail($id);
        $realisasiPanen->update($request->all());

        return response()->json(['success' => 'Data berhasil diperbarui.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $realisasiPanen = RealisasiPanen::findOrFail($id);
            $realisasiPanen->delete();

            return redirect()->route('realisasipanen.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            dd('Error: ' . $e->getMessage() . ' ID: ' . $id);
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        Excel::import(new RealisasipanenImport, $request->file('file'));

        return redirect()->route('realisasipanen.index')->with('success', 'Data berhasil diupload.');
    }

    public function exportExcel(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $userEstate = Auth::user()->estate ?? null;

        return Excel::download(new RealisasiPanenExport($minDate, $maxDate, $userEstate), 'realisasi_panen.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $userEstate = Auth::user()->estate ?? null;

        $pdfExport = new RealisasiPanenPdfExport($minDate, $maxDate, $userEstate);
        return $pdfExport->generatePdf();
    }
}
