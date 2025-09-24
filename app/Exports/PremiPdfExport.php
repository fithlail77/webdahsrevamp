<?php

namespace App\Exports;

use App\Models\Premi;
use Barryvdh\DomPDF\Facade\Pdf;

class PremiPdfExport
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
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

        if ($this->startDate && $this->endDate) {
            $query->whereDate('tanggal', '>=', $this->startDate)->whereDate('tanggal', '<=', $this->endDate);
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
