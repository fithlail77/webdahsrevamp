<?php

namespace App\Imports;

use App\Models\Contractcpo;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContractcpoImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Contractcpo([
            'ggu_sc' => $row['ggu_sc'],
            'gum_sc' => $row['gum_sc'],
            'plan_loading_tk' => $row['plan_loading_tk'],
            'real_loading_tk' => $row['real_loading_tk'],
            'tgl_ba_loading_tk' => $row['tgl_ba_loading_tk'],
            'tgl_pricing' => $row['tgl_pricing'],
            'real_price' => $row['real_price'],
            'nilai_penjualan' => $row['nilai_penjualan'],
            'kontrak_qty_ton' => $row['kontrak_qty_ton'],
            'real_qty_kg' => $row['real_qty_kg'],
            'kapal_tongkang' => $row['kapal_tongkang'],
            'suhu' => $row['suhu'],
            'buyer' => $row['buyer'],
            'status' => $row['status'],
            'lama_loading_hari' => $row['lama_loading_hari'],
            'real_loading' => $row['real_loading'],
            'bulan' => $row['bulan'],
            'bln_name' => $row['bln_name'],
            'plan_bln_name' => $row['plan_bln_name'],
        ]);
    }
}
