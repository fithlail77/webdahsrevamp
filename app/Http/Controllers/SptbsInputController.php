<?php

namespace App\Http\Controllers;

use App\Models\SptbsInput;
use App\Exports\SptbsExport;
use Illuminate\Http\Request;
use App\Exports\SptbsPdfExport;
use App\Imports\SptbsInputImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class SptbsInputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('vsptbs.index');
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
        ]);

        if($request->minDate && $request->maxDate) {
            $query->whereBetween('tanggal_tiket', [$request->minDate, $request->maxDate]);
        } elseif ($request->minDate) {
            $query->whereDate('tanggal_tiket', '>=', $request->minDate);
        } elseif ($request->maxDate) {
            $query->whereDate('tanggal_tiket', '<=', $request->maxDate);
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
        $request->validate([
            'angkutan' => 'required|string|max:5',
            'no_tiket' => 'required|integer',
            'tanggal_tiket' => 'required|date',
            'no_sptbs' => 'required|integer',
            'tanggal_sptbs' => 'required|date',
            'tanggal_panen' => 'required|date',
            'nama_supir' => 'required|string|max:30',
            'no_polisi' => 'required|string|max:15',
            'jam_masuk' => 'required|time',
            'jam_keluar' => 'required|time',
            'estate' => 'required|string|max:15',
            'divisi' => 'required|string|max:5',
            'blok' => 'required|string|max:5',
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

        return Excel::download(new SptbsExport($minDate, $maxDate), 'sptbs.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');

        $pdfExport = new SptbsPdfExport($minDate, $maxDate);
        return $pdfExport->generatePdf();
    }
}
