<?php

namespace App\Exports;

use App\Models\ArestaOld;
use Barryvdh\DomPDF\Facade\Pdf;

class ArestaPdfExport
{

    protected $startDate;
    protected $endDate;
    protected $search;

    public function __construct($startDate = null, $endDate = null, $search = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->search = $search;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function generatePdf()
    {
        $query = ArestaOld::select([
            'bulan',
            'estate',
            'divisi',
            'blok',
            'tahun_tanam',
            'status_tanaman',
            'status_lahan',
            'jenis_bibit',
            'topografi',
            'jenis_tanah',
            'pokok',
            'luas'
        ]);

        // Jika ada pencarian, ambil semua data tanpa filter tanggal
        if (!empty($this->search)) {
            // Tidak ada filter tanggal
        } else {
            // Jika ada filter tanggal, gunakan itu
            if ($this->startDate && $this->endDate) {
                $query->whereDate('bulan', '>=', $this->startDate)->whereDate('bulan', '<=', $this->endDate);
            } elseif ($this->startDate) {
                $query->whereDate('bulan', '>=', $this->startDate);
            } elseif ($this->endDate) {
                $query->whereDate('bulan', '<=', $this->endDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('bulan', '>=', \Carbon\Carbon::now()->subDays(30));
            }
        }

        $data = $query->get()->map(function ($item) {
            return [
                'bulan' => \Carbon\Carbon::parse($item->bulan)->format('d-m-Y'),
                'estate' => $item->estate,
                'divisi' => $item->divisi,
                'blok' => $item->blok,
                'tahun_tanam' => $item->tahun_tanam,
                'status_tanaman' => $item->status_tanaman,
                'status_lahan' => $item->status_lahan,
                'jenis_bibit' => $item->jenis_bibit,
                'topografi' => $item->topografi,
                'jenis_tanah' => $item->jenis_tanah,
                'pokok' => $item->pokok,
                'luas' => $item->luas
            ];
        });

        $pdf = Pdf::loadView('aresta.pdf', compact('data'))->setPaper('a4', 'portrait');
        return $pdf->download('Areal_Statement.pdf');
    }
}
