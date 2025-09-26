<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('vrental.index');
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
        ->whereDate('tanggal','>=', now()->subDays(30)->format('Y-m-d'))
        ->orderBy('tanggal','desc');

        if($request->minDate && $request->maxDate) {
            $query->whereBetween('tanggal', [$request->minDate, $request->maxDate]);
        } elseif ($request->minDate) {
            $query->whereDate('tanggal', '>=', $request->minDate);
        } elseif ($request->maxDate) {
            $query->whereDate('tanggal', '<=', $request->maxDate);
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
}
