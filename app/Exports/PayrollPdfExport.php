<?php

namespace App\Exports;

use App\Models\Payroll;
use Barryvdh\DomPDF\Facade\Pdf;



class PayrollPdfExport 
{

    protected $minDate;
    protected $maxDate;
    protected $search;

    public function __construct($minDate = null, $maxDate = null, $search = null)
    {
        $this->minDate = $minDate;
        $this->maxDate = $maxDate;
        $this->search = $search;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function generatePdf()
    {
        $query = Payroll::select([
            'tanggal',
            'estate',
            'periode',
            'tahun',
            'divisi',
            'nik',
            'nama',
            'status',
            'pembayaran',
            'blok',
            'tahun_tanam',
            'jenis_pekerjaan',
            'divisi_2',
            'kelompok',
            'coa',
            'ket',
            't_rp',
            'jjg',
            'hasil',
            'sat',
            'hasil_2',
            'sat_21',
            'total',
            'jenis_pupuk',
            'jm_1',
            'qty_1',
            'sat_1',
            'jm_2',
            'qty_2',
            'sat_2',
            'jm_3',
            'qty_3',
            'sat_3',
            'nik_mandor',
            'nama_mandor',
            'hk',
            'hk1',
        ]);

        // Jika ada pencarian, ambil semua data tanpa filter tanggal
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('nik', 'like', '%' . $this->search . '%')
                  ->orWhere('estate', 'like', '%' . $this->search . '%')
                  ->orWhere('divisi', 'like', '%' . $this->search . '%');
            });
        } else {
            // Jika ada filter tanggal, gunakan itu
            if ($this->minDate && $this->maxDate) {
                $query->whereDate('tanggal', '>=', $this->minDate)->whereDate('tanggal', '<=', $this->maxDate);
            } elseif ($this->minDate) {
                $query->whereDate('tanggal', '>=', $this->minDate);
            } elseif ($this->maxDate) {
                $query->whereDate('tanggal', '<=', $this->maxDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('tanggal', '>=', \Carbon\Carbon::now()->subDays(30));
            }
        }

        $data = $query->get()->map(function ($item) {
            return [
                'tanggal' => $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') : '-',
                'estate' => $item->estate,
                'periode' => $item->periode,
                'tahun' => $item->tahun,
                'divisi' => $item->divisi,
                'nik' => $item->nik,
                'nama' => $item->nama,
                'status' => $item->status,
                'pembayaran' => $item->pembayaran,
                'blok' => $item->blok,
                'tahun_tanam' => $item->tahun_tanam,
                'jenis_pekerjaan' => $item->jenis_pekerjaan,
                'divisi_2' => $item->divisi_2,
                'kelompok' => $item->kelompok,
                'coa' => $item->coa,
                'ket' => $item->ket,
                't_rp' => $item->t_rp,
                'jjg' => $item->jjg,
                'hasil' => $item->hasil,
                'sat' => $item->sat,
                'hasil_2' => $item->hasil_2,
                'sat_21' => $item->sat_21,
                'total' => $item->total,
                'jenis_pupuk' => $item->jenis_pupuk,
                'jm_1' => $item->jm_1,
                'qty_1' => $item->qty_1,
                'sat_1' => $item->sat_1,
                'jm_2' => $item->jm_2,
                'qty_2' => $item->qty_2,
                'sat_2' => $item->sat_2,
                'jm_3' => $item->jm_3,
                'qty_3' => $item->qty_3,
                'sat_3' => $item->sat_3,
                'nik_mandor' => $item->nik_mandor,
                'nama_mandor' => $item->nama_mandor,
                'hk' => $item->hk,
                'hk1' => $item->hk1,
            ];
        });

        $pdf = Pdf::loadView('payroll.pdf', compact('data'))->setPaper('a2', 'landscape');
        return $pdf->download('Payroll.pdf');
    }
}
