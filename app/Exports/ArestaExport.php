<?php

namespace App\Exports;

use App\Models\Aresta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ArestaExport implements FromCollection, WithHeadings
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
    public function collection()
    {
        $query = Aresta::select([
            'bulan',
            'estate',
            'divisi',
            'blok',
            'tahun_tanam',
            'status_tanaman',
            'status_lahan',
            'jenis_bibit',
            'topografi',
            'jenis_tanah',
            'pokok',
            'luas'
        ]);

        if ($this->startDate && $this->endDate) {
            $query->whereDate('bulan', '>=', $this->startDate)->whereDate('bulan', '<=', $this->endDate);
        }

        return $query->get()->map(function ($item) {
            return [
                'bulan' => \Carbon\Carbon::parse($item->bulan)->format('d-m-Y'),
                'estate' => $item->estate,
                'divisi' => $item->divisi,
                'blok' => $item->blok,
                'tahun_tanam' => $item->tahun_tanam,
                'status_tanaman' => $item->status_tanaman,
                'status_lahan' => $item->status_lahan,
                'jenis_bibit' => $item->jenis_bibit,
                'topografi' => $item->topografi,
                'jenis_tanah' => $item->jenis_tanah,
                'pokok' => $item->pokok,
                'luas' => $item->luas
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Estate',
            'Divisi',
            'Blok',
            'Tahun Tanam',
            'Status Tanaman',
            'Status Lahan',
            'Jenis Bibit',
            'Topografi',
            'Jenis Tanah',
            'Pokok',
            'Luasan'
        ];
    }
}
