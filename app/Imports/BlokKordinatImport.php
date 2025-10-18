<?php

namespace App\Imports;

use App\Models\BlokKordinat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class BlokKordinatImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(Array $row)
    {
        // Debug: log the row data
        Log::info('Importing row:', $row);

        // Check if required fields exist
        if (!isset($row['estate']) || !isset($row['divisi']) || !isset($row['blok'])) {
            Log::error('Missing required fields in row:', $row);
            return null; // Skip this row
        }

        return new BlokKordinat([
            'estate' => $row['estate'] ?? null,
            'divisi' => $row['divisi'] ?? null,
            'blok' => $row['blok'] ?? null,
            'x' => $row['x'] ?? null,
            'y' => $row['y'] ?? null,
            'l1' => $row['l1'] ?? null,
            'l2' => $row['l2'] ?? null,
            'poly_id' => $row['poly_id'] ?? null
        ]);
    }
}
