<?php

namespace App\Exports;

use App\Models\Ffbinternal;
use Barryvdh\DomPDF\Facade\Pdf;

class FfbInternalPdfExport
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
        $query = Ffbinternal::select([
            'no_po',
            'vendor_detail',
            'vendor_group',
            'vendor_transportir',
            'tgl',
            'bln',
            'thn',
            'tanggal',
            'time_in',
            'time_out',
            'no_plat',
            'driver',
            'bruto_awal',
            'tarra',
            'ton_bruto',
            'grading',
            'netto',
            'jml_tandan',
            'bjr',
            'area',
            'umur_tanaman',
            'bulan',
            'estate',
            'divisi',
            'asal_tbs',
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
                'no_po' => $item->no_po,
                'vendor_detail' => $item->vendor_detail,
                'vendor_group' => $item->vendor_group,
                'vendor_transportir' => $item->vendor_transportir,
                'tgl' => $item->tgl,
                'bln' => $item->bln,
                'thn' => $item->thn,
                'tanggal' => \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y'),
                'time_in' => $item->time_in,
                'time_out' => $item->time_out,
                'no_plat' => $item->no_plat,
                'driver' => $item->driver,
                'bruto_awal' => $item->bruto_awal,
                'tarra' => $item->tarra,
                'ton_bruto' => $item->ton_bruto,
                'grading' => $item->grading,
                'netto' => $item->netto,
                'jml_tandan' => $item->jml_tandan,
                'bjr' => $item->bjr,
                'area' => $item->area,
                'umur_tanaman' => $item->umur_tanaman,
                'bulan' => \Carbon\Carbon::parse($item->bulan)->format('d-m-Y'),
                'estate' => $item->estate,
                'divisi' => $item->divisi,
                'asal_tbs' => $item->asal_tbs,
            ];
        });

        $pdf = Pdf::loadView('ffbint.pdf', compact('data'))->setPaper('a2', 'landscape');
        return $pdf->download('FFB_Internal.pdf');
    }
}
