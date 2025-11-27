<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Aramco;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Exports\AramcoExport;
use App\Imports\AramcoImport;
use App\Exports\AramcoPdfExport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class AramcoController extends Controller
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

        return view('varamco.index', compact('estate','divisi'));
    }

    public function data(Request $request)
    {
        $query = Aramco::select([
            'id',
            'tanggal_rakit',
            'tanggal_pasang',
            'no_po',
            'ukuran',
            'jumlah',
            'satuan',
            'blok',
            'estate',
            'divisi',
            'kordinat',
            'tahun_tanam',
            'lahan',
            'status'
        ])
        ->orderBy('tanggal_pasang','desc');

        // Jika ada pencarian global, ambil semua data tanpa filter tanggal
        if (!empty($request->input('search.value'))) {
            // Tidak ada filter tanggal, ambil semua
        } else {
            // Jika ada filter tanggal, gunakan itu
            if($request->minDate && $request->maxDate) {
                $query->whereBetween('tanggal_pasang', [$request->minDate, $request->maxDate]);
            } elseif ($request->minDate) {
                $query->whereDate('tanggal_pasang', '>=', $request->minDate);
            } elseif ($request->maxDate) {
                $query->whereDate('tanggal_pasang', '<=', $request->maxDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('tanggal_pasang', '>=', Carbon::now()->subDays(30));
            }
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('tanggal_formatted', function ($row) {
                return \Carbon\Carbon::parse($row['tanggal_pasang'])->format('d-m-Y');
            })
            ->addColumn('tanggal_formatted1', function ($row) {
                return \Carbon\Carbon::parse($row['tanggal_rakit'])->format('d-m-Y');
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditAramco"><i class="fa fa-edit"></i></a>
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
            'tanggal_rakit' => 'required|date',
            'tanggal_pasang' => 'required|date',
            'no_po' => 'required|string|max:30',
            'ukuran' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'satuan' => 'required|string|max:10',
            'blok' => 'required|string|max:10',
            'estate' => 'required|string|max:35',
            'divisi' => 'required|string|max:5',
            'kordinat' => 'required|string|max:255',
            'tahun_tanam' => 'required|integer',
            'lahan' => 'required|string|max:30',
            'status' => 'required|string|max:30'
        ]);

        Aramco::create([
            'tanggal_rakit' => $request->tanggal_rakit,
            'tanggal_pasang' => $request->tanggal_pasang,
            'no_po' => $request->no_po,
            'ukuran' => $request->ukuran,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'blok' => $request->blok,
            'estate' => $request->estate,
            'divisi' => $request->divisi,
            'kordinat' => $request->kordinat,
            'tahun_tanam' => $request->tahun_tanam,
            'lahan' => $request->lahan,
            'status' => $request->status
        ]);

        return redirect()->route('aramco.index')->with('success', 'Data Aramco berhasil disimpan.');
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
            $aramco = Aramco::findOrFail($id);
            return response()->json($aramco);
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
                'tanggal_rakit' => 'required|date',
                'tanggal_pasang' => 'required|date',
                'no_po' => 'nullable|string|max:30',
                'ukuran' => 'required|string|max:255',
                'jumlah' => 'required|integer',
                'satuan' => 'required|string|max:10',
                'blok' => 'required|string',
                'estate' => 'required|string|max:35',
                'divisi' => 'required|string|max:5',
                'kordinat' => 'required|string|max:255',
                'tahun_tanam' => 'required|integer',
                'lahan' => 'required|string|max:30',
                'status' => 'required|string|max:30'
            ]);

            $aramco = Aramco::findOrFail($id);
            $aramco->update($request->all());

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

        Excel::import( new AramcoImport, $request->file('file'));

        return redirect()->route('aramco.index')->with('success', 'Data berhasil diupload.');
    }

    public function exportExcel(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');

        return Excel::download(new AramcoExport($minDate, $maxDate), 'Monitoring_Aramco.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');

        $pdfExport = new AramcoPdfExport($minDate, $maxDate);
        return $pdfExport->generatePdf();
    }
}
