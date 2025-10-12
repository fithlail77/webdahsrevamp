<?php

namespace App\Exports;

use App\Models\Premi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PremiExport implements FromCollection, WithHeadings
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
        $query = Premi::select([
            'tanggal',
            'no_kab',
            'nama_kab',
            'nik',
            'nama_karyawan',
            'estate',
            'hmkm_awal',
            'hmkm_akhir',
            'total_hmkm',
            'lokasi',
            'divisi',
            'jenis_pekerjaan',
            'tarif_satuan',
            'hasil_1',
            'satuan_1',
            'hasil_2',
            'satuan_2',
            'total_premi'
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
                'no_kab' => $item->no_kab,
                'nama_kab' => $item->nama_kab,
                'nik' => $item->nik,
                'nama_karyawan' => $item->nama_karyawan,
                'estate' => $item->estate,
                'hmkm_awal' => $item->hmkm_awal,
                'hmkm_akhir' => $item->hmkm_akhir,
                'total_hmkm' => $item->total_hmkm,
                'lokasi' => $item->lokasi,
                'divisi' => $item->divisi,
                'jenis_pekerjaan' => $item->jenis_pekerjaan,
                'tarif_satuan' => $item->tarif_satuan,
                'hasil_1' => $item->hasil_1,
                'satuan_1' => $item->satuan_1,
                'hasil_2' => $item->hasil_2,
                'satuan_2' => $item->satuan_2,
                'total_premi' => $item->total_premi,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'No KAB',
            'Nama KAB',
            'NIK',
            'Nama Karyawan',
            'Estate',
            'HM/KM Awal',
            'HM/KM Akhir',
            'Total HM/KM',
            'Lokasi',
            'Divisi',
            'Jenis Pekerjaan',
            'Tarif Satuan',
            'Hasil 1',
            'Satuan 1',
            'Hasil 2',
            'Satuan 2',
            'Total Premi'
        ];
    }
}
