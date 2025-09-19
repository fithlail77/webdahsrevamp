<?php

namespace App\Exports;

use App\Models\Restan;
use Barryvdh\DomPDF\Facade\Pdf;

class LapRestanPdfExport
{
    protected $minDate;
    protected $maxDate;

    public function __construct($minDate = null, $maxDate = null)
    {
        $this->minDate = $minDate;
        $this->maxDate = $maxDate;
    }

    public function generatePdf()
    {
        $query = Restan::select([
            'tanggal',
            'estate',
            'divisi',
            'blok',
            'tonase',
            'keterangan',
        ]);

        if ($this->minDate && $this->maxDate) {
            $query->whereBetween('tanggal', [$this->minDate, $this->maxDate]);
        } elseif ($this->minDate) {
            $query->whereDate('tanggal', '>=', $this->minDate);
        } elseif ($this->maxDate) {
            $query->whereDate('tanggal', '<=', $this->maxDate);
        }

        $data = $query->get()->map(function ($item) {
            return [
                'tanggal' => \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y'),
                'estate' => $item->estate,
                'divisi' => $item->divisi,
                'blok' => $item->blok,
                'tonase' => $item->tonase,
                'keterangan' => $item->keterangan,
            ];
        });

        $pdf = Pdf::loadView('laprestan.pdf', compact('data'));
        return $pdf->download('laporan_restan.pdf');
    }

}
