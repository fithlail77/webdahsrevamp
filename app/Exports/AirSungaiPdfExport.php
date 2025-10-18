<?php

namespace App\Exports;

use App\Models\AirSungai;
use Barryvdh\DomPDF\Facade\Pdf;

class AirSungaiPdfExport
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
        $query = AirSungai::select([
            'tanggal',
            'pagi_m',
            'sore_m',
            'rataan'
        ]);

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
                'pagi_m' => $item->pagi_m,
                'sore_m' => $item->sore_m,
                'rataan' => $item->rataan,
            ];
        });

        $pdf = Pdf::loadView('airsungai.pdf', compact('data'))->setPaper('a4', 'potrait');
        return $pdf->download('Air_Sungai.pdf');        
    }
}
