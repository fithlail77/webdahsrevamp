<?php

namespace App\Exports;

use App\Models\ChInput;
use Barryvdh\DomPDF\Facade\Pdf;

class CurahHujanPdfExport
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
        $query = ChInput::select([
            'pt',
            'dates',
            'estate',
            'divisi',
            'ch',
        ]);

          // Jika ada pencarian, ambil semua data tanpa filter tanggal
        if (!empty($this->search)) {
            // Tidak ada filter tanggal
        } else {
            // Jika ada filter tanggal, gunakan itu
            if ($this->minDate && $this->maxDate) {
                $query->whereDate('dates', '>=', $this->minDate)->whereDate('dates', '<=', $this->maxDate);
            } elseif ($this->minDate) {
                $query->whereDate('dates', '>=', $this->minDate);
            } elseif ($this->maxDate) {
                $query->whereDate('dates', '<=', $this->maxDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('dates', '>=', \Carbon\Carbon::now()->subDays(30));
            }
        }

        $data = $query->get()->map(function ($item) {
            return [
                'pt' => $item->pt,
                'dates' => \Carbon\Carbon::parse($item->dates)->format('d-m-Y'),
                'estate' => $item->estate,
                'divisi' => $item->divisi,
                'ch' => $item->ch
            ];
        });

        $pdf = Pdf::loadView('ch.pdf', compact('data'))->setPaper('a4', 'potrait');
        return $pdf->download('Curah_Hujan.pdf');
    }
}
