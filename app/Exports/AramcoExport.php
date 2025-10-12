<?php

namespace App\Exports;

use App\Models\Aramco;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AramcoExport implements FromCollection, WithHeadings
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

        return $query->get()->map(function ($item) {
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
    }

    public function headings(): array
    {
        return [
            'Tanggal Perakitan',
            'Tanggal Pasang',
            'No PO',
            'Ukuran',
            'Jumlah',
            'Satuan',
            'Blok',
            'Estate',
            'Divisi',
            'Kordinat',
            'Tahun Tanam',
            'Lahan',
            'Status'
        ];
    }
}
