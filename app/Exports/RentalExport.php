<?php

namespace App\Exports;

use App\Models\Rental;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RentalExport implements FromCollection, WithHeadings
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
