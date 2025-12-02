<?php

namespace App\Exports;

use App\Models\Aramco;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;


class AramcoPdfExport 
{
    protected $minDate;
    protected $maxDate;
    protected $userEstate;


    public function __construct($minDate = null, $maxDate = null, $userEstate = null)
    {
        $this->minDate = $minDate;
        $this->maxDate = $maxDate;
        $this->userEstate = $userEstate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function generatePdf()
    {
        $query = Aramco::select([
            'tanggal_rakit',
            'tanggal_pasang',
            'no_po',
            'ukuran',
            'jumlah',
            'satuan',
            'blok',
            'estate',
            'divisi',
            'kordinat',
            'tahun_tanam',
            'lahan',
            'status'
        ]);

        // Filter berdasarkan estate user
        $userEstate = Auth::user()->estate ?? null;
        if ($userEstate && $userEstate !== 'all') {
            $query->where('estate', $userEstate);
        }

          // Jika ada pencarian, ambil semua data tanpa filter tanggal
        if (!empty($this->search)) {
            // Tidak ada filter tanggal
        } else {
            // Jika ada filter tanggal, gunakan itu
            if ($this->minDate && $this->maxDate) {
                $query->whereDate('tanggal_pasang', '>=', $this->minDate)->whereDate('tanggal_pasang', '<=', $this->maxDate);
            } elseif ($this->minDate) {
                $query->whereDate('tanggal_pasang', '>=', $this->minDate);
            } elseif ($this->maxDate) {
                $query->whereDate('tanggal_pasang', '<=', $this->maxDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('tanggal_pasang', '>=', \Carbon\Carbon::now()->subDays(30));
            }
        }

        $data = $query->get()->map(function ($item) {
            return [
                'tanggal_rakit' => \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y'),
                'tanggal_pasang' => \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y'),
                'no_po' => $item->no_po,
                'ukuran' => $item->ukuran,
                'jumlah' => $item->jumlah,
                'satuan' => $item->satuan,
                'blok' => $item->blok,
                'estate' => $item->estate,
                'divisi' => $item->divisi,
                'kordinat' => $item->kordinat,
                'tahun_tanam' => $item->tahun_tanam,
                'lahan' => $item->lahan,
                'status' => $item->status
            ];
        });

        $pdf = Pdf::loadView('varamco.pdf', compact('data'))->setPaper('a3', 'landscape');
        return $pdf->download('Monitoring_aramco.pdf');
    }
}
