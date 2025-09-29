<?php

namespace App\Exports;

use App\Models\Rental;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RentalExport implements FromCollection, WithHeadings
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
        $query = Rental::select([
            'tanggal',
            'estate',
            'jenis_alat',
            'no_alat',
            'operator',
            'hm_awal',
            'hm_akhir',
            'total_hm',
            'potongan_hm',
            'pembayaran_hm',
            'blok',
            'tahun_tanam',
            'pekerjaan',
            'divisi',
            'kelompok',
            'coa',
            'tarif',
            'bjr',
            'hasil_1',
            'satuan_1',
            'hasil_2',
            'satuan_2',
            'total_biaya'
        ]);

        if ($this->startDate && $this->endDate) {
            $query->whereDate('tanggal', '>=', $this->startDate)->whereDate('tanggal', '<=', $this->endDate);
        }

        return $query->get()->map(function ($item) {
            return [
                'tanggal' => \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y'),
                'estate' => $item->estate,
                'jenis_alat' => $item->jenis_alat,
                'no_alat' => $item->no_alat,
                'operator' => $item->operator,
                'hm_awal' => $item->hm_awal,
                'hm_akhir' => $item->hm_akhir,
                'total_hm' => $item->total_hm,
                'potongan_hm' => $item->potongan_hm,
                'pembayaran_hm' => $item->pembayaran_hm,
                'blok' => $item->blok,
                'tahun_tanam' => $item->tahun_tanam,
                'pekerjaan' => $item->pekerjaan,
                'divisi' => $item->divisi,
                'kelompok' => $item->kelompok,
                'coa' => $item->coa,
                'tarif' => $item->tarif,
                'bjr' => $item->bjr,
                'hasil_1' => $item->hasil_1,
                'satuan_1' => $item->satuan_1,
                'hasil_2' => $item->hasil_2,
                'satuan_2' => $item->satuan_2,
                'total_biaya' => $item->total_biaya
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Estate',
            'Jenis Alat',
            'Nomor Alat',
            'Operator',
            'HM Awal',
            'HM Akhir',
            'Total HM',
            'Potongan HM',
            'Pembayaran HM',
            'Blok',
            'Tahun Tanam',
            'Pekerjaan',
            'Divisi',
            'Kelompok',
            'COA',
            'Tarif',
            'BJR',
            'Hasil 1',
            'Satuan 1',
            'Hasil 2',
            'Satuan 2',
            'Total Biaya'
        ];
    }
}
