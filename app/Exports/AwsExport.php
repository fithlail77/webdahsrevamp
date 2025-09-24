<?php

namespace App\Exports;

use App\Models\Aws;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class AwsExport implements FromCollection, WithHeadings
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
        $query = Aws::select([
            'time',
            'date',
            'temp',
            'humid',
            'sol_rad',
            'rainfall',
            'air_pres',
            'wind_speed',
            'wind_dir',
            'et',
            'sunshine',
            'index_uv',

        ])
        ->orderBy('date', 'desc');

        if ($this->startDate && $this->endDate) {
            $query->whereDate('date', '>=', $this->startDate)->whereDate('date', '<=', $this->endDate);
        }

        return $query->get()->map(function ($item) {
            return [
                'time' => $item->time,
                'date' => \Carbon\Carbon::parse($item->date)->format('d-m-Y'),
                'temp' => number_format($item->temp, 2),
                'humid' => number_format($item->humid, 2),
                'sol_rad' => number_format($item->sol_rad, 2),
                'rainfall' => number_format($item->rainfall, 2),
                'air_pres' => number_format($item->air_pres, 2),
                'wind_speed' => number_format($item->wind_speed, 2),
                'wind_dir' => number_format($item->wind_dir, 2),
                'et' => number_format($item->et, 2),
                'sunshine' => number_format($item->sunshine, 2),
                'index_uv' => number_format($item->index_uv, 2),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Waktu',
            'Tanggal',
            'Suhu (°C)',
            'Kelembaban (%)',
            'Solar Radiation (W/m²)',
            'Curah Hujan (mm)',
            'Tekanan Udara (mb)',
            'Kecepatan Angin (m/s)',
            'Arah Angin (°)',
            'ET (mm)',
            'Sinar Matahari (h/d)',
            'Ultraviolet (index)',
        ];
    }
}