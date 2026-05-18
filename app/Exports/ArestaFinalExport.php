<?php

namespace App\Exports;

use App\Models\Aresta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ArestaFinalExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Aresta::select([
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
        ]);

        return $query->get()->map(function ($item) {
            return [
                'estate' => $item->estate,
                'divisi' => $item->divisi,
                'blok' => $item->blok,
                'lahan' => $item->lahan,
                'tahun_tanam' => $item->tahun_tanam,
                'bibit' => $item->bibit,
                'topografi' => $item->topografi,
                'jenis_tanah' => $item->jenis_tanah,
                'status' => $item->status,
                'jml_pokok' => $item->jml_pokok,
                'luas' => $item->luas,
                'sph' => $item->sph
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Estate',
            'Divisi',
            'Blok',
            'Lahan',
            'Tahun Tanam',
            'Jenis Bibit',
            'Topografi',
            'Jenis Tanah',
            'Status',
            'Jumlah Pokok',
            'Luas',
            'SPH',
        ];
    }
}
