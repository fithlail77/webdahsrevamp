<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\SptbsInput;
use App\Exports\SptbsExport;
use Illuminate\Http\Request;
use App\Exports\SptbsPdfExport;
use App\Imports\SptbsInputImport;
use App\Models\Company;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class SptbsInputController extends Controller
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

        return view('vsptbs.index', compact('estate','divisi'));
    }

    public function data(Request $request)
    {
        $query = SptbsInput::select([
            'id',
            'angkutan',
            'no_tiket',
            'tanggal_tiket',
            'no_sptbs',
            'tanggal_sptbs',
            'tanggal_panen',
            'nama_supir',
            'no_polisi',
            'jam_masuk',
            'jam_keluar',
            'estate',
            'divisi',
            'blok',
            'tahun_tanam',
            'lahan',
            'jumlah_tandan',
            'berondolan',
            'berat_bruto',
            'berat_tarra',
            'berat_netto',
            'jumlah_grading',
            'berat_bersih',
            'bjr',
        ])
        ->orderBy('jam_masuk','asc');

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
                $query->whereBetween('tanggal_tiket', [$request->minDate, $request->maxDate]);
            } elseif ($request->minDate) {
                $query->whereDate('tanggal_tiket', '>=', $request->minDate);
            } elseif ($request->maxDate) {
                $query->whereDate('tanggal_tiket', '<=', $request->maxDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('tanggal_tiket', '>=', Carbon::now()->subDays(30));
            }
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('tanggal_formatted1', function ($row) {
                return \Carbon\Carbon::parse($row['tanggal_tiket'])->format('d-m-Y');
            })
            ->addColumn('tanggal_formatted2', function ($row) {
                return \Carbon\Carbon::parse($row['tanggal_sptbs'])->format('d-m-Y');
            })
            ->addColumn('tanggal_formatted3', function ($row) {
                return \Carbon\Carbon::parse($row['tanggal_panen'])->format('d-m-Y');
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditSptbs"><i class="fa fa-edit"></i></a>
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
        return view('vsptbs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sptbs = $request->input('sptbs');

        foreach ($sptbs as $data) {
            SptbsInput::create([
                'angkutan' => $data['angkutan'],
                'no_tiket' => $data['no_tiket'],
                'tanggal_tiket' => $data['tanggal_tiket'],
                'no_sptbs' => $data['no_sptbs'],
                'tanggal_sptbs' => $data['tanggal_sptbs'],
                'tanggal_panen' => $data['tanggal_panen'],
                'nama_supir' => $data['nama_supir'],
                'no_polisi' => $data['no_polisi'],
                'jam_masuk' => $data['jam_masuk'],
                'jam_keluar' => $data['jam_keluar'],
                'estate' => $data['estate'],
                'divisi' => $data['divisi'],
                'blok' => $data['blok'],
                'tahun_tanam' => $data['tahun_tanam'],
                'lahan' => $data['lahan'],
                'jumlah_tandan' => $data['jumlah_tandan'],
                'berondolan' => $data['berondolan'],
                'berat_bruto' => $data['berat_bruto'],
                'berat_tarra' => $data['berat_tarra'],
                'berat_netto' => $data['berat_netto'],
                'jumlah_grading' => $data['jumlah_grading'],
                'berat_bersih' => $data['berat_bersih'],
                'bjr' => $data['bjr']
            ]);
        }

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
            $sptbs = SptbsInput::findOrFail($id);
            return response()->json($sptbs);
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
                'angkutan' => 'required|string|max:5',
                'no_tiket' => 'required|integer',
                'tanggal_tiket' => 'required|date',
                'no_sptbs' => 'required|integer',
                'tanggal_sptbs' => 'required|date',
                'tanggal_panen' => 'required|date',
                'nama_supir' => 'required|string|max:30',
                'no_polisi' => 'required|string|max:15',
                'jam_masuk' => 'nullable|string',
                'jam_keluar' => 'nullable|string',
                'estate' => 'required|string|max:15',
                'divisi' => 'required|string|max:5',
                'blok' => 'required|string|max:5',
                'tahun_tanam' => 'required|integer',
                'lahan' => 'required|string|max:30',
                'jumlah_tandan' => 'required|integer',
                'berondolan' => 'required|numeric',
                'berat_bruto' => 'required|numeric',
                'berat_tarra' => 'required|numeric',
                'berat_netto' => 'required|numeric',
                'jumlah_grading' => 'required|numeric',
                'berat_bersih' => 'required|numeric',
                'bjr' => 'required|numeric',
            ]);

            $sptbs = SptbsInput::findOrFail($id);
            $sptbs->update($request->all());

            return response()->json(['success' => 'Data berhasil diperbarui.']);
        } catch (\Exception $e) {
            Log::error('Error updating SPTBS: ' . $e->getMessage());
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

        Excel::import( new SptbsInputImport, $request->file('file'));

        return redirect()->route('sptbs.index')->with('success', 'Data berhasil diupload.');
    }

    public function exportExcel(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $userEstate = Auth::user()->estate ?? null;

        return Excel::download(new SptbsExport($minDate, $maxDate, $userEstate), 'sptbs.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $userEstate = Auth::user()->estate ?? null;

        $pdfExport = new SptbsPdfExport($minDate, $maxDate, $userEstate);
        return $pdfExport->generatePdf();
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'angkutan' => 'required|string|max:5',
            'notiket' => 'required|integer',
            'tgltiket' => 'required|date',
            'nosptbs' => 'required|integer',
            'tglsptbs' => 'required|date',
            'tglpanen' => 'required|date',
            'supir' => 'required|string|max:30',
            'nopol' => 'required|string|max:15',
            'timein' => 'nullable|string',
            'timeout' => 'nullable|string',
            'estate' => 'required|string|max:15',
            'divisi' => 'required|string|max:5',
            'blok' => 'required|string|max:5',
            'tahuntanam' => 'required|integer',
            'lahan' => 'required|string|max:30',
            'jmltandan' => 'required|integer',
            'berondolan' => 'required|numeric',
            'bruto' => 'required|numeric',
            'tarra' => 'required|numeric',
            'netto' => 'required|numeric',
            'grading' => 'required|numeric',
            'bersih' => 'required|numeric',
            'bjr' => 'required|numeric',
        ]);

        SptbsInput::create([
            'angkutan' => $request->angkutan,
            'no_tiket' => $request->notiket,
            'tanggal_tiket' => $request->tgltiket,
            'no_sptbs' => $request->nosptbs,
            'tanggal_sptbs' => $request->tglsptbs,
            'tanggal_panen' => $request->tglpanen,
            'nama_supir' => $request->supir,
            'no_polisi' => $request->nopol,
            'jam_masuk' => $request->timein,
            'jam_keluar' => $request->timeout,
            'estate' => $request->estate,
            'divisi' => $request->divisi,
            'blok' => $request->blok,
            'tahun_tanam' => $request->tahuntanam,
            'lahan' => $request->lahan,
            'jumlah_tandan' => $request->jmltandan,
            'berondolan' => $request->berondolan,
            'berat_bruto' => $request->bruto,
            'berat_tarra' => $request->tarra,
            'berat_netto' => $request->netto,
            'jumlah_grading' => $request->grading,
            'berat_bersih' => $request->bersih,
            'bjr' => $request->bjr,
        ]);

        return redirect()->route('sptbs.index')->with('success', 'Data SPTBS berhasil disimpan.');
    }
}
