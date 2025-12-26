<?php

namespace App\Exports;

use App\Models\TSA;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class TsaExport implements FromCollection, WithHeadings
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
    public function collection()
    {
        $query = TSA::select([
            'tanggal',
            'no_ticket',
            'transportir',
            'supir',
            'nopol',
            'material',
            'satuan',
            'blok',
            'tt',
            'estate',
            'divisi',
            'lahan',
            'bruto',
            'tara',
            'netto'
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
                'no_ticket' => $item->no_ticket,
                'transportir' => $item->transportir,
                'supir' => $item->supir,
                'nopol' => $item->nopol,
                'material' => $item->material,
                'satuan' => $item->satuan,
                'blok' => $item->blok,
                'tt' => $item->tt,
                'estate' => $item->estate,
                'divisi' => $item->divisi,
                'lahan' => $item->lahan,
                'bruto' => $item->bruto,
                'tara' => $item->tara,
                'netto' => $item->netto
            ];
        });
        
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'No Tiket',
            'Transportir',
            'Supir',
            'No Polisi',
            'Material',
            'Satuan',
            'Blok',
            'Tahun Tanam',
            'Estate',
            'Divisi',
            'Lahan',
            'Bruto',
            'Tara',
            'Netto'
        ];
    }
}
