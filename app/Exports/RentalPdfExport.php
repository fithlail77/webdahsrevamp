<?php

namespace App\Exports;

use App\Models\Rental;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class RentalPdfExport 
{

    protected $minDate;
    protected $maxDate;
    protected $userEstate;

    public function __construct($minDate = null, $maxDate = null, $userEstate = null)
    {
        $this->minDate = $minDate;
        $this->maxDate = $maxDate;
        $this->userEstate = $userEstate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function generatePdf()
    {
        $query = Rental::select([
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
            'total_biaya'
        ]);

        // Filter berdasarkan estate user
        $userEstate = Auth::user()->estate ?? null;
        if ($userEstate && $userEstate !== 'all') {
            $query->where('estate', $userEstate);
        }

        // Jika ada pencarian, ambil semua data tanpa filter tanggal
        if (!empty($this->search)) {
            // Tidak ada filter tanggal
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
                'tanggal' => \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y'),
                'estate' => $item->estate,
                'jenis_alat' => $item->jenis_alat,
                'no_alat' => $item->no_alat,
                'operator' => $item->operator,
                'hm_awal' => $item->hm_awal,
                'hm_akhir' => $item->hm_akhir,
                'total_hm' => $item->total_hm,
                'potongan_hm' => $item->potongan_hm,
                'pembayaran_hm' => $item->pembayaran_hm,
                'blok' => $item->blok,
                'tahun_tanam' => $item->tahun_tanam,
                'pekerjaan' => $item->pekerjaan,
                'divisi' => $item->divisi,
                'kelompok' => $item->kelompok,
                'coa' => $item->coa,
                'tarif' => $item->tarif,
                'bjr' => $item->bjr,
                'hasil_1' => $item->hasil_1,
                'satuan_1' => $item->satuan_1,
                'hasil_2' => $item->hasil_2,
                'satuan_2' => $item->satuan_2,
                'total_biaya' => $item->total_biaya
            ];
        });

        $pdf = Pdf::loadView('vrental.pdf', compact('data'))->setPaper('a3', 'landscape');
        return $pdf->download('realisasi_rental_kab_data.pdf');
    }
}
