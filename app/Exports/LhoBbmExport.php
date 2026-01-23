<?php

namespace App\Exports;

use App\Models\LhoBbm;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class LhoBbmExport implements FromCollection, WithHeadings
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
        $query = LhoBbm::select([
            'id',
            'i_no',
            'material_code',
            'name',
            'unit',
            'i_qty',
            'i_date',
            'post_date',
            'stor_loct',
            'desc',
            'bulan',
            'no_unit',
            'nama_unit',
            'kelompok_unit',
            'biaya_bbm'
        ]);

        // Jika ada pencarian, ambil semua data tanpa filter tanggal
        if (!empty($this->search)) {
            // Tidak ada filter tanggal
        } else {
            // Jika ada filter tanggal, gunakan itu
            if ($this->minDate && $this->maxDate) {
                $query->whereDate('i_date', '>=', $this->minDate)->whereDate('i_date', '<=', $this->maxDate);
            } elseif ($this->minDate) {
                $query->whereDate('i_date', '>=', $this->minDate);
            } elseif ($this->maxDate) {
                $query->whereDate('i_date', '<=', $this->maxDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('i_date', '>=', \Carbon\Carbon::now()->subDays(30));
            }
        }

        return $query->get()->map(function ($item) {
            return [
                'i_no' => $item->i_no,
                'material_code' => $item->material_code,
                'name' => $item->name,
                'unit' => $item->unit,
                'i_qty' => $item->i_qty,
                'i_date' => $item->i_date,
                'post_date' => $item->post_date,
                'stor_loct' => $item->stor_loct,
                'desc' => $item->desc,
                'bulan' => $item->bulan,
                'no_unit' => $item->no_unit,
                'nama_unit' => $item->nama_unit,
                'kelompok_unit' => $item->kelompok_unit,
                'biaya_bbm' => $item->biaya_bbm,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nomor',
            'Kode Material',
            'Nama',
            'Unit',
            'Jumlah',
            'Tanggal',
            'Tanggal Posting',
            'Lokasi Penyimpanan',
            'Deskripsi',
            'Bulan',
            'Nomor Unit',
            'Nama Unit',
            'Kelompok Unit',
            'Biaya BBM'
        ];
    }
}
