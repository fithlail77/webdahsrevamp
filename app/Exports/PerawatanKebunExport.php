<?php

namespace App\Exports;

use App\Models\PerawatanKebun;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PerawatanKebunExport implements FromCollection, WithHeadings
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

        if ($this->startDate && $this->endDate) {
            $query->whereDate('tanggal', '>=', $this->startDate)->whereDate('tanggal', '<=', $this->endDate);
        }

        return $query->get()->map(function ($item) {
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
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Jenis Perawatan',
            'Blok',
            'Tahun Tanam',
            'Divisi',
            'Estate',
            'Lahan',
            'Hasil',
            'Satuan',
            'Jumlah Tenaga',
            'Material 1',
            'Jumlah 1',
            'Satuan 1',
            'Material 2',
            'Jumlah 2',
            'Satuan 2',
            'Material 3',
            'Jumlah 3',
            'Satuan 3',
            'Keterangan'
        ];
    }
}
