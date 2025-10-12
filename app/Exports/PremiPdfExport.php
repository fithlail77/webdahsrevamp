<?php

namespace App\Exports;

use App\Models\Premi;
use Barryvdh\DomPDF\Facade\Pdf;

class PremiPdfExport
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

    public function generatePdf()
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
            'total_premi',
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

        $data = $query->get()->map(function ($item) {
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

        $pdf = Pdf::loadView('vpremi.pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->download('premi_data.pdf');
    }

}
