<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\PerawatanKebun;
use Barryvdh\DomPDF\Facade\Pdf;


class PerawatanKebunPdfExport 
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
        $query = PerawatanKebun::select([
            'tanggal',
            'jenis_perawatan',
            'blok',
            'tahun_tanam',
            'divisi',
            'estate',
            'lahan',
            'hasil',
            'satuan',
            'jml_tenaga',
            'material_1',
            'jumlah_1',
            'satuan_1',
            'material_2',
            'jumlah_2',
            'satuan_2',
            'material_3',
            'jumlah_3',
            'satuan_3',
            'keterangan'
        ]);

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
                'jenis_perawatan' => $item->jenis_perawatan,
                'blok' => $item->blok,
                'tahun_tanam' => $item->tahun_tanam,
                'divisi' => $item->divisi,
                'estate' => $item->estate,
                'lahan' => $item->lahan,
                'hasil' => $item->hasil,
                'satuan' => $item->satuan,
                'jml_tenaga' => $item->jml_tenaga,
                'material_1' => $item->material_1,
                'jumlah_1' => $item->jumlah_1,
                'satuan_1' => $item->satuan_1,
                'material_2' => $item->material_2,
                'jumlah_2' => $item->jumlah_2,
                'satuan_2' => $item->satuan_2,
                'material_3' => $item->material_3,
                'jumlah_3' => $item->jumlah_3,
                'satuan_3' => $item->satuan_3,
                'keterangan' => $item->keterangan
            ];
        });

        $pdf = Pdf::loadView('vrawatkebun.pdf', compact('data'))->setPaper('a3', 'landscape');
        return $pdf->download('perawatan_kebun.pdf');
    }
}
