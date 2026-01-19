<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Rental;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Exports\RentalExport;
use App\Imports\RentalImport;
use App\Exports\RentalPdfExport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\ValidationException;

class RentalController extends Controller
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

        return view('vrental.index', compact('estate','divisi'));
    }

    public function data(Request $request)
    {
        $query = Rental::select([
            'id',
            'tanggal',
            'estate',
            'jenis_alat',
            'no_alat',
            'operator',
            'hm_awal',
            'hm_akhir',
            'total_hm',
            'potongan_hm',
            'pembayaran_hm',
            'blok',
            'tahun_tanam',
            'pekerjaan',
            'divisi',
            'kelompok',
            'coa',
            'tarif',
            'bjr',
            'hasil_1',
            'satuan_1',
            'hasil_2',
            'satuan_2',
            'total_biaya',
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
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditRental"><i class="fa fa-edit"></i></a>
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
            'estate' => 'required|string|max:35',
            'jenis_alat' => 'required|string|max:255',
            'no_alat' => 'required|string|max:255',
            'operator' => 'required|string|max:150',
            'hm_awal' => 'required|numeric',
            'hm_akhir' => 'required|numeric',
            'total_hm' => 'required|numeric',
            'potongan_hm' => 'nullable|numeric',
            'pembayaran_hm' => 'nullable|numeric',
            'blok' => 'nullable|string|max:5',
            'tahun_tanam' => 'required|integer',
            'pekerjaan' => 'required|string|max:255',
            'divisi' => 'required|string|max:5',
            'kelompok' => 'required|string|max:255',
            'coa' => 'nullable|integer',
            'tarif' => 'nullable|integer',
            'bjr' => 'nullable|numeric',
            'hasil_1' => 'nullable|integer',
            'satuan_1' => 'nullable|string|max:15',
            'hasil_2' => 'nullable|integer',
            'satuan_2' => 'nullable|string|max:15',
            'total_biaya' => 'nullable|integer'
        ]);

        Rental::create([
            'tanggal' => $request->tanggal,
            'estate' => $request->estate,
            'jenis_alat' => $request->jenis_alat,
            'no_alat' => $request->no_alat,
            'operator' => $request->operator,
            'hm_awal' => $request->hm_awal,
            'hm_akhir' => $request->hm_akhir,
            'total_hm' => $request->total_hm,
            'potongan_hm' => $request->potongan_hm,
            'pembayaran_hm' => $request->pembayaran_hm,
            'blok' => $request->blok,
            'tahun_tanam' => $request->tahun_tanam,
            'pekerjaan' => $request->pekerjaan,
            'divisi' => $request->divisi,
            'kelompok' => $request->kelompok,
            'coa' => $request->coa,
            'tarif' => $request->tarif,
            'bjr' => $request->bjr,
            'hasil_1' => $request->hasil_1,
            'satuan_1' => $request->satuan_1,
            'hasil_2' => $request->hasil_2,
            'satuan_2' => $request->satuan_2,
            'total_biaya' => $request->total_biaya
        ]);

        return redirect()->route('rental.index')->with('success', 'Data Rental Alat & Kenderaan berhasil disimpan.');
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
            $rental = Rental::findOrFail($id);
            return response()->json($rental);
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
                'estate' => 'required|string|max:35',
                'jenis_alat' => 'required|string|max:255',
                'no_alat' => 'required|string|max:255',
                'operator' => 'required|string|max:150',
                'hm_awal' => 'required|numeric',
                'hm_akhir' => 'required|numeric',
                'total_hm' => 'required|numeric',
                'potongan_hm' => 'nullable|numeric',
                'pembayaran_hm' => 'nullable|numeric',
                'blok' => 'nullable|string|max:5',
                'tahun_tanam' => 'required|integer',
                'pekerjaan' => 'required|string|max:255',
                'divisi' => 'required|string|max:5',
                'kelompok' => 'required|string|max:255',
                'coa' => 'nullable|integer',
                'tarif' => 'nullable|integer',
                'bjr' => 'nullable|numeric',
                'hasil_1' => 'nullable|integer',
                'satuan_1' => 'nullable|string|max:15',
                'hasil_2' => 'nullable|integer',
                'satuan_2' => 'nullable|string|max:15',
                'total_biaya' => 'nullable|integer',
            ]);

            $rental = Rental::findOrFail($id);
            $rental->update($request->all());

            return response()->json(['success' => 'Data berhasil diperbarui.']);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validasi gagal: ' . implode(', ', $e->errors())], 422);
        } catch (\Throwable $e) {
            Log::error('Error updating Rental: ' . $e->getMessage());
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

        Excel::import( new RentalImport, $request->file('file'));

        return redirect()->route('rental.index')->with('success', 'Data berhasil diupload.');
    }

    public function exportExcel(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $userEstate = Auth::user()->estate ?? null;

        return Excel::download(new RentalExport($minDate, $maxDate, $userEstate), 'realisasi_kab.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $userEstate = Auth::user()->estate ?? null;

        $pdfExport = new RentalPdfExport($minDate, $maxDate, $userEstate);
        return $pdfExport->generatePdf();
    }
}
