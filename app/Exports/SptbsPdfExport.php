<?php

namespace App\Exports;

use App\Models\SptbsInput;
use Barryvdh\DomPDF\Facade\Pdf;

class SptbsPdfExport
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function generatePdf()
    {
        $query = SptbsInput::select([
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

        if ($this->startDate && $this->endDate) {
            $query->whereDate('tanggal_tiket', '>=', $this->startDate)->whereDate('tanggal_tiket', '<=', $this->endDate);
        }

        $data = $query->get()->map(function ($item) {
            return [
                'angkutan' => $item->angkutan,
                'no_tiket' => $item->no_tiket,
                'tanggal_tiket' => \Carbon\Carbon::parse($item->tanggal_tiket)->format('d-m-Y'),
                'no_sptbs' => $item->no_sptbs,
                'tanggal_sptbs' => \Carbon\Carbon::parse($item->tanggal_sptbs)->format('d-m-Y'),
                'tanggal_panen' => \Carbon\Carbon::parse($item->tanggal_panen)->format('d-m-Y'),
                'nama_supir' => $item->nama_supir,
                'no_polisi' => $item->no_polisi,
                'jam_masuk' => $item->jam_masuk,
                'jam_keluar' => $item->jam_keluar,
                'estate' => $item->estate,
                'divisi' => $item->divisi,
                'blok' => $item->blok,
                'tahun_tanam' => $item->tahun_tanam,
                'lahan' => $item->lahan,
                'jumlah_tandan' => $item->jumlah_tandan,
                'berondolan' => $item->berondolan,
                'berat_bruto' => $item->berat_bruto,
                'berat_tarra' => $item->berat_tarra,
                'berat_netto' => $item->berat_netto,
                'jumlah_grading' => $item->jumlah_grading,
                'berat_bersih' => $item->berat_bersih,
                'bjr' => $item->bjr,
            ];
        });

        $pdf = Pdf::loadView('vsptbs.pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->download('sptbs_data.pdf');
    }
}
