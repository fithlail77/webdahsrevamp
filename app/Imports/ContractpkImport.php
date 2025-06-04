<?php

namespace App\Imports;

use App\Models\Contractpk;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContractpkImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Contractpk([
            'ltc' => $row['ltc'],
            'nomor_sc' => $row['nomor_sc'],
            'bln_name' => $row['bln_name'],
            'date_pricing' => $row['date_pricing'],
            'price' => $row['price'],
            'dicount_ggu' => $row['dicount_ggu'],
            'real_price' => $row['real_price'],
            'dp_date' => $row['dp_date'],
            'rencana_awal_kirim' => $row['rencana_awal_kirim'],
            'rencana_closed_kirim' => $row['rencana_closed_kirim'],
            'actual_awal_kirim' => $row['actual_awal_kirim'],
            'actual_closed_kirim' => $row['actual_closed_kirim'],
            'qty_kontrak_kg' => $row['qty_kontrak_kg'],
            'buyer' => $row['buyer'],
            'status' => $row['status'],
            'real_qty_kg' => $row['real_qty_kg'],
            'buyer_received_qty_kg' => $row['buyer_received_qty_kg'],
            'rp' => $row['rp'],
            'keterangan' => $row['keterangan'],
            'bulan' => $row['bulan'],
        ]);
    }
}
