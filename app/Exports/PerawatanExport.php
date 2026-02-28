<?php

namespace App\Exports;

use App\Models\Perawatan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PerawatanExport implements FromCollection, WithHeadings
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
        $query = Perawatan::select([
            'tanggal',
            'bulan',
            'tahun_jalan',
            'tahun',
            'nik',
            'nama',
            'status',
            'pembayaran',
            'blok',
            'tt',
            'kelompok',
            'coa',
            'ket',
            'tarif_rp',
            'bjr',
            'hasil',
            'sat',
            'hasil_2',
            'sat_2',
            'total',
            'periode',
            'period_txt',
            'tahun_period',
            'estate',
            'divisi',
            'jenis_pekerjaan',
            'areal',
            'keterangan',
            'sph',
            'ha',
            'hk',
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
                'bulan' => \Carbon\Carbon::parse($item->bulan)->format('d-m-Y'),
                'tahun_jalan' => $item->tahun_jalan,
                'tahun' => $item->tahun,
                'nik' => $item->nik,
                'nama' => $item->nama,
                'status' => $item->status,
                'pembayaran' => $item->pembayaran,
                'blok' => $item->blok,
                'tt' => $item->tt,
                'kelompok' => $item->kelompok,
                'coa' => $item->coa,
                'ket' => $item->ket,
                'tarif_rp' => $item->tarif_rp,
                'bjr' => $item->bjr,
                'hasil' => $item->hasil,
                'sat' => $item->sat,
                'hasil_2' => $item->hasil_2,
                'sat_2' => $item->sat_2,
                'total' => $item->total,
                'periode' => \Carbon\Carbon::parse($item->periode)->format('d-m-Y'),
                'period_txt' => $item->period_txt,
                'tahun_period' => $item->tahun_period,
                'estate' => $item->estate,
                'divisi' => $item->divisi,
                'jenis_pekerjaan' => $item->jenis_pekerjaan,
                'areal' => $item->areal,
                'keterangan' => $item->keterangan,
                'sph' => $item->sph,
                'ha' => $item->ha,
                'hk' => $item->hk,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Bulan',
            'Tahun Jalan',
            'Tahun',
            'NIK',
            'Nama',
            'Status',
            'Pembayaran',
            'Blok',
            'TT',
            'Kelompok',
            'COA',
            'Keterangan',
            'Tarif (Rp)',
            'BJR',
            'Hasil',
            'Satuan Hasil',
            'Hasil 2',
            'Satuan Hasil 2',
            'Total',
            'Periode',
            'Period Text',
            'Tahun Periode',
            'Estate',
            'Divisi',
            'Jenis Pekerjaan',
            'Areal',
            'Keterangan',
            'SPH',
            'Ha',
            'HK',
        ];
    }
}
