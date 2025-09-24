<?php

namespace App\Exports;

use App\Models\Aws;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class AwsPdfExport
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

        $data = $query->get()->map(function ($item) {
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

        $pdf = Pdf::loadView('aws.pdf', compact('data'));
        return $pdf->download('aws_data.pdf');
    }
}