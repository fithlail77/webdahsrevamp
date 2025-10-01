<?php

namespace App\Exports;

use App\Models\Aramco;
use Barryvdh\DomPDF\Facade\Pdf;


class AramcoPdfExport 
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function generatePdf()
    {
        $query = Aramco::select([
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
        ]);

        if ($this->startDate && $this->endDate) {
            $query->whereDate('tanggal_pasang', '>=', $this->startDate)->whereDate('tanggal_pasang', '<=', $this->endDate);
        }

        $data = $query->get()->map(function ($item) {
            return [
                'tanggal_rakit' => \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y'),
                'tanggal_pasang' => \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y'),
                'no_po' => $item->no_po,
                'ukuran' => $item->ukuran,
                'jumlah' => $item->jumlah,
                'satuan' => $item->satuan,
                'blok' => $item->blok,
                'estate' => $item->estate,
                'divisi' => $item->divisi,
                'kordinat' => $item->kordinat,
                'tahun_tanam' => $item->tahun_tanam,
                'lahan' => $item->lahan,
                'status' => $item->status
            ];
        });

        $pdf = Pdf::loadView('varamco.pdf', compact('data'))->setPaper('a3', 'landscape');
        return $pdf->download('Monitoring_aramco.pdf');
    }
}
