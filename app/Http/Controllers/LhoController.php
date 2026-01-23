<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\LhoBbm;
use Illuminate\Http\Request;
use App\Imports\LhobbmImport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LhoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lho.index');
    }

    public function data(Request $request)
    {
        $query = LhoBbm::select([
            'id',
            'i_no',
            'material_code',
            'name',
            'unit',
            'i_qty',
            'i_date',
            'post_date',
            'stor_loct',
            'desc',
            'bulan',
            'no_unit',
            'nama_unit',
            'kelompok_unit',
            'biaya_bbm'
        ])
        ->orderBy('i_date','desc');

        // Jika ada pencarian global, ambil semua data tanpa filter tanggal
        if (!empty($request->input('search.value'))) {
            // Tidak ada filter tanggal, ambil semua
        } else {
            // Jika ada filter tanggal, gunakan itu
            if($request->minDate && $request->maxDate) {
                $query->whereBetween('i_date', [$request->minDate, $request->maxDate]);
            } elseif ($request->minDate) {
                $query->whereDate('i_date', '>=', $request->minDate);
            } elseif ($request->maxDate) {
                $query->whereDate('i_date', '<=', $request->maxDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('i_date', '>=', Carbon::now()->subDays(30));
            }
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('tanggal_formatted', function ($row) {
                return \Carbon\Carbon::parse($row['i_date'])->format('d-m-Y');
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditBbm"><i class="fa fa-edit"></i></a>
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
        //
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

        Excel::import(new LhobbmImport, $request->file('file'));

        return redirect()->route('lho.index')->with('success', 'Data berhasil diupload.');

    }
}
