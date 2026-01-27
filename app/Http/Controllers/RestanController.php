<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Restan;
use App\Models\Aresta;
use Illuminate\Http\Request;
use App\Exports\LapRestanExport;
use App\Exports\LapRestanPdfExport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class RestanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userEstate = Auth::user()->estate ?? null;

        $estate = Aresta::select('estate')
            ->distinct()
            ->when($userEstate && $userEstate !== 'all', function ($query) use ($userEstate) {
                return $query->where('estate', $userEstate);
            })
            ->get();

        $divisi = Aresta::select('divisi')
            ->distinct()
            ->orderBy('divisi', 'asc')
            ->when($userEstate && $userEstate !== 'all', function ($query) use ($userEstate) {
                return $query->where('estate', $userEstate);
            })
            ->get();

        return view('laprestan.index', compact('estate', 'divisi', 'userEstate'));
    }

    public function data(Request $request)
    {
        $query = Restan::select([
            'id',
            'tanggal',
            'estate',
            'divisi',
            'blok',
            'tonase',
            'keterangan',
            'tt',
        ])
            ->orderBy('tanggal', 'desc');

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
            if ($request->minDate && $request->maxDate) {
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
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditRestan"><i class="fa fa-edit"></i></a>
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
            'estate' => 'required|string|max:30',
            'divisi' => 'required|string|max:5',
            'blok' => 'required|string|max:5',
            'tonase' => 'required|integer',
            'keterangan' => 'required|string|max:255',
            'tt' => 'required|integer',
        ]);

        Restan::create([
            'tanggal' => $request->tanggal,
            'estate' => $request->estate,
            'divisi' => $request->divisi,
            'blok' => $request->blok,
            'tonase' => $request->tonase,
            'keterangan' => $request->keterangan,
            'tt' => $request->tt,
        ]);

        return redirect()->route('laprestan.index')->with('success', 'Data Restan berhasil disimpan.');
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
            $lapRestan = Restan::findOrFail($id);
            return response()->json($lapRestan);
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
            'estate' => 'required|string|max:255',
            'divisi' => 'required|string|max:5',
            'blok' => 'required|string|max:5',
            'tonase' => 'required|numeric',
            'keterangan' => 'required|string|max:255',
            'tt' => 'required|integer',
        ]);

        $lapRestan = Restan::findOrFail($id);
        $lapRestan->update($request->all());

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

        Excel::import(new \App\Imports\RestanImport, $request->file('file'));

        return redirect()->route('laprestan.index')->with('success', 'Data berhasil diupload.');
    }

    public function exportExcel(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $userEstate = Auth::user()->estate ?? null;

        return Excel::download(new LapRestanExport($minDate, $maxDate, $userEstate), 'laporan_restan.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $userEstate = Auth::user()->estate ?? null;

        $pdfExport = new LapRestanPdfExport($minDate, $maxDate, $userEstate);
        return $pdfExport->generatePdf();
    }

    public function getDivisi(Request $request)
    {
        $estate = $request->estate;
        $userEstate = Auth::user()->estate ?? null;

        $divisi = Aresta::select('divisi')
            ->where('estate', $estate)
            ->when($userEstate && $userEstate !== 'all', function ($query) use ($userEstate) {
                return $query->where('estate', $userEstate);
            })
            ->distinct()
            ->orderBy('divisi')
            ->get();

        return response()->json($divisi);
    }

    public function getBlok(Request $request)
    {
        $estate = $request->estate;
        $divisi = $request->divisi;
        $userEstate = Auth::user()->estate ?? null;

        $blok = Aresta::select('blok')
            ->where('estate', $estate)
            ->where('divisi', $divisi)
            ->when($userEstate && $userEstate !== 'all', function ($query) use ($userEstate) {
                return $query->where('estate', $userEstate);
            })
            ->distinct()
            ->orderBy('blok')
            ->get();

        return response()->json($blok);
    }

    public function getTahunTanam(Request $request)
    {
        $estate = $request->estate;
        $divisi = $request->divisi;
        $blok = $request->blok;
        $userEstate = Auth::user()->estate ?? null;

        $tahunTanam = Aresta::select('tahun_tanam')
            ->where('estate', $estate)
            ->where('divisi', $divisi)
            ->where('blok', $blok)
            ->when($userEstate && $userEstate !== 'all', function ($query) use ($userEstate) {
                return $query->where('estate', $userEstate);
            })
            ->distinct()
            ->orderBy('tahun_tanam')
            ->get();

        return response()->json($tahunTanam);
    }
}
