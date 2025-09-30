<?php

namespace App\Exports;

use App\Models\PemupukanKebun;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PemupukanKebunExport implements FromCollection, WithHeadings
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
        $query = PemupukanKebun::select([
            'tanggal',
            'jenis_pupuk',
            'blok',
            'tahun_tanam',
            'divisi',
            'estate',
            'lahan',
            'hasil',
            'pokok',
            'dosis',
            'jml_tenaga',
            'keterangan'
        ]);

        if ($this->startDate && $this->endDate) {
            $query->whereDate('tanggal', '>=', $this->startDate)->whereDate('tanggal', '<=', $this->endDate);
        }

        return $query->get()->map(function ($item) {
            return [
                'tanggal' => \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y'),
                'jenis_pupuk' => $item->jenis_pupuk,
                'blok' => $item->blok,
                'tahun_tanam' => $item->tahun_tanam,
                'divisi' => $item->divisi,
                'estate' => $item->estate,
                'lahan' => $item->lahan,
                'hasil' => $item->hasil,
                'pokok' => $item->pokok,
                'dosis' => $item->dosis,
                'jml_tenaga' => $item->jml_tenaga,
                'keterangan' => $item->keterangan
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Jenis Pupuk',
            'Blok',
            'Tahun Tanam',
            'Divisi',
            'Estate',
            'Lahan',
            'Hasil',
            'Pokok',
            'Dosis',
            'Jumlah Tenaga',
            'Keterangan'
        ];
    }
}