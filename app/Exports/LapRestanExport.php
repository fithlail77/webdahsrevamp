<?php

namespace App\Exports;

use App\Models\Restan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class LapRestanExport implements FromCollection, WithHeadings
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
        $query = Restan::select([
            'tanggal',
            'estate',
            'divisi',
            'blok',
            'tonase',
            'keterangan',
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
                'estate' => $item->estate,
                'divisi' => $item->divisi,
                'blok' => $item->blok,
                'tonase' => $item->tonase,
                'keterangan' => $item->keterangan,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Estate',
            'Divisi',
            'Blok',
            'Tonase',
            'Keterangan',
        ];
    }
}
