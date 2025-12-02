<?php

namespace App\Exports;

use App\Models\PemupukanKebun;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PemupukanKebunPdfExport
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
        $query = PemupukanKebun::select([
            'tanggal',
            'jenis_pupuk',
            'blok',
            'tahun_tanam',
            'divisi',
            'estate',
            'lahan',
            'hasil',
            'pokok',
            'dosis',
            'jml_tenaga',
            'keterangan'
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
                'jenis_pupuk' => $item->jenis_pupuk,
                'blok' => $item->blok,
                'tahun_tanam' => $item->tahun_tanam,
                'divisi' => $item->divisi,
                'estate' => $item->estate,
                'lahan' => $item->lahan,
                'hasil' => $item->hasil,
                'pokok' => $item->pokok,
                'dosis' => $item->dosis,
                'jml_tenaga' => $item->jml_tenaga,
                'keterangan' => $item->keterangan
            ];
        });

        $pdf = Pdf::loadView('vpupukebun.pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->download('pemupukan_kebun.pdf');
    }
}