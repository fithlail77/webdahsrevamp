<?php

namespace App\Http\Controllers;

use App\Exports\TsaExport;
use App\Exports\TsaExportPdf;
use App\Models\TSA;
use App\Models\Company;
use App\Models\Aresta;
use App\Imports\TsaImport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class TSAController extends Controller
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
            ->orderBy('estate', 'asc')
            ->get();

        $divisi = Aresta::select('divisi')
            ->distinct()
            ->orderBy('divisi', 'asc')
            ->when($userEstate && $userEstate !== 'all', function ($query) use ($userEstate) {
                return $query->where('estate', $userEstate);
            })
            ->get();

        return view('vtsa.index', compact('estate', 'divisi', 'userEstate'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function data(Request $request)
    {
        $query = TSA::select([
            'id',
            'tanggal',
            'no_ticket',
            'transportir',
            'supir',
            'nopol',
            'material',
            'satuan',
            'blok',
            'tt',
            'estate',
            'divisi',
            'lahan',
            'bruto',
            'tara',
            'netto'
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
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditTSA"><i class="fa fa-edit"></i></a>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $validate = $request->validate([
            'tanggal' => 'required|date',
            'no_ticket' => 'required|integer',
            'transportir' => 'required|string|max:15',
            'supir' => 'required|string|max:30',
            'nopol' => 'required|string|max:15',
            'material' => 'required|string|max:30',
            'satuan' => 'required|string|max:5',
            'blok' => 'required|string|max:5',
            'tt' => 'required|integer',
            'estate' => 'required|string|max:30',
            'divisi' => 'required|string|max:5',
            'lahan' => 'required|string|max:15',
            'bruto' => 'required|integer',
            'tara' => 'required|integer',
            'netto' => 'required|integer',
          ]);

          TSA::create($validate);

          return response()->json(['message' => 'Data berhasil disimpan.']);
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
            $tsa = TSA::findOrFail($id);
            return response()->json($tsa);
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
             'no_ticket' => 'required|integer',
             'transportir' => 'required|string|max:15',
             'supir' => 'required|string|max:30',
             'nopol' => 'required|string|max:15',
             'material' => 'required|string|max:30',
             'satuan' => 'required|string|max:5',
             'blok' => 'required|string|max:5',
             'tt' => 'required|integer',
             'estate' => 'required|string|max:30',
             'divisi' => 'required|string|max:5',
             'lahan' => 'required|string|max:15',
             'bruto' => 'required|integer',
             'tara' => 'required|integer',
             'netto' => 'required|integer',
        ]);

        $tsa = TSA::findOrFail($id);
        $tsa->update($request->all());

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

        Excel::import( new TsaImport, $request->file('file'));

        return redirect()->route('tsa.index')->with('success', 'Data berhasil diupload.');
    }

    public function getDivisi(Request $request)
    {
        $estate = $request->estate;
        $userEstate = Auth::user()->estate ?? null;

        if ($userEstate && $userEstate !== 'all' && $estate !== $userEstate) {
            return response()->json([]);
        }

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

        if ($userEstate && $userEstate !== 'all' && $estate !== $userEstate) {
            return response()->json([]);
        }

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

        if ($userEstate && $userEstate !== 'all' && $estate !== $userEstate) {
            return response()->json([]);
        }

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

    public function exportExcel(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');

        return Excel::download(new TsaExport($minDate, $maxDate), 'monitoring_tankos_solid_abuboiler.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $search = $request->input('search');

        $pdfExport = new TsaExportPdf($minDate, $maxDate, $search);
        return $pdfExport->generatePdf();
    }
}
