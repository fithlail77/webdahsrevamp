<?php

namespace App\Exports;

use App\Models\Restan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;

class LapRestanExport implements FromCollection, WithHeadings
{
    protected $minDate;
    protected $maxDate;

    public function __construct($minDate = null, $maxDate = null)
    {
        $this->minDate = $minDate;
        $this->maxDate = $maxDate;
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

        if ($this->minDate && $this->maxDate) {
            $query->whereBetween('tanggal', [$this->minDate, $this->maxDate]);
        } elseif ($this->minDate) {
            $query->whereDate('tanggal', '>=', $this->minDate);
        } elseif ($this->maxDate) {
            $query->whereDate('tanggal', '<=', $this->maxDate);
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
