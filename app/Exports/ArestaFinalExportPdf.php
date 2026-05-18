<?php

namespace App\Exports;

use App\Models\Aresta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

class ArestaFinalExportPdf
{
    protected $limit = 1000;

    public function generatePdf()
    {
        $data = Aresta::select([
            'estate',
            'divisi',
            'blok',
            'lahan',
            'tahun_tanam',
            'bibit',
            'topografi',
            'jenis_tanah',
            'status',
            'jml_pokok',
            'luas',
            'sph',
        ])
        ->orderBy('id', 'asc')
        ->limit($this->limit)
        ->get();

        $pdf = Pdf::loadView('varestafinal.pdf', compact('data', 'limit'))
            ->setPaper('a4', 'landscape')
            ->setOptions(['isRemoteEnabled' => false, 'isHtml5ParserEnabled' => true]);

        return $pdf->download('aresta_v1_final.pdf');
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }
}
