<?php

namespace App\Exports;

use App\Models\TSA;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;


class TsaExportPdf
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
    * @return \Illuminate\Http\Response
    */
    public function generatePdf()
    {
        $query = TSA::select([
            'tanggal',
            'no_ticket',
            'transportir',
            'supir',
            'nopol',
            'material',
            'satuan',
            'blok',
            'tt',
            'estate',
            'divisi',
            'lahan',
            'bruto',
            'tara',
            'netto'
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
                'no_ticket' => $item->no_ticket,
                'transportir' => $item->transportir,
                'supir' => $item->supir,
                'nopol' => $item->nopol,
                'material' => $item->material,
                'satuan' => $item->satuan,
                'blok' => $item->blok,
                'tt' => $item->tt,
                'estate' => $item->estate,
                'divisi' => $item->divisi,
                'lahan' => $item->lahan,
                'bruto' => $item->bruto,
                'tara' => $item->tara,
                'netto' => $item->netto
            ];
        })->toArray();

        $pdf = Pdf::loadView('vtsa.pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->download('monitoring_tankos_solid_abuboiler.pdf');
    }
}
