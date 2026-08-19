<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\LsuInput;
use App\Imports\LsuInputImport;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class LsuInputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil tahun unik dari tabel LsuInput, diurutkan dari yang terbaru
        $tahunList = LsuInput::select('tahun')
                        ->distinct()
                        ->orderBy('tahun', 'desc')
                        ->pluck('tahun');

        // LOGIKA PENENTUAN TAHUN DEFAULT
        $tahunSaatIni = Carbon::now()->year;
        $tahunKemarin = Carbon::now()->subYear()->year;

        // Cek apakah ada data untuk tahun saat ini di database
        $adaDataTahunIni = LsuInput::where('tahun', $tahunSaatIni)->exists();

        // Jika ada, gunakan tahun saat ini. Jika tidak, gunakan tahun kemarin.
        $defaultTahun = $adaDataTahunIni ? $tahunSaatIni : $tahunKemarin;

        return view('lsu.index', compact('tahunList', 'defaultTahun'));
    }

    public function data(Request $request)
    {
        $query = LsuInput::select([
            'id',
            'tahun',
            'blok',
            'estate',
            'divisi',
            'tahun_tanam',
            'blok_tt',
            'luas',
            'pokok',
            'lsu',
            'unsur_hara',
        ]);

        return DataTables::of($query)
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && !empty($request->input('search.value'))) {
                    // Global search otomatis dari Yajra
                } else {
                    // Cek dropdown tahun
                    if ($request->filled('tahun')) {
                        $query->where('tahun', $request->tahun);
                    } else {
                        // Fallback (jika request tahun kosong)
                        $tahunSaatIni = Carbon::now()->year;
                        if (LsuInput::where('tahun', $tahunSaatIni)->exists()) {
                            $query->where('tahun', $tahunSaatIni);
                        } else {
                            $query->where('tahun', Carbon::now()->subYear()->year);
                        }
                    }
                }
            })
            ->order(function ($query) {
                $query->orderBy('tahun', 'desc');
            })
            ->addIndexColumn()
            ->editColumn('luas', function ($row) {
                return number_format((float)$row->luas, 2, ',', '');
            })
            ->editColumn('lsu', function ($row) {
                return number_format((float)$row->lsu, 2, ',', '');
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditFfbInternal">
                        <i class="fa fa-edit"></i>
                    </a>
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
            $lsuinput = LsuInput::findOrFail($id);
            return response()->json($lsuinput);
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

        Excel::import(new LsuInputImport, $request->file('file'));

        return redirect()->route('lsuinput.index')->with('success', 'Data berhasil diupload.');
    }
}
