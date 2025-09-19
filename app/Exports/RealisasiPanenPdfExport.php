<?php

namespace App\Exports;

use App\Models\RealisasiPanen;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RealisasiPanenPdfExport
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
        $query = RealisasiPanen::select([
            'tanggal',
            'jenis_kerja',
            'blok',
            'tt',
            'divisi',
            'estate',
            'hasil',
            'satuan',
            'tk',
            'ha_panen',
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
                'jenis_kerja' => $item->jenis_kerja,
                'blok' => $item->blok,
                'tt' => $item->tt,
                'divisi' => $item->divisi,
                'estate' => $item->estate,
                'hasil' => $item->hasil,
                'satuan' => $item->satuan,
                'tk' => $item->tk,
                'ha_panen' => $item->ha_panen,
            ];
        });

        $pdf = Pdf::loadView('rpanen.pdf', compact('data'));
        return $pdf->download('realisasi_panen.pdf');
    }
}