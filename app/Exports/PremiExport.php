<?php

namespace App\Exports;

use App\Models\Premi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PremiExport implements FromCollection, WithHeadings
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

        if ($this->startDate && $this->endDate) {
            $query->whereDate('tanggal', '>=', $this->startDate)->whereDate('tanggal', '<=', $this->endDate);
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
