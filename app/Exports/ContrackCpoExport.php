<?php

namespace App\Exports;

use App\Models\Contractcpo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContrackCpoExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $minDate;
    protected $maxDate;
    protected $search;

    public function __construct($minDate = null, $maxDate = null, $search = null)
    {
        $this->minDate = $minDate;
        $this->maxDate = $maxDate;
        $this->search = $search;
    }

    public function collection()
    {
        $query = Contractcpo::select([
            'ggu_sc',
            'gum_sc',
            'plan_loading_tk',
            'real_loading_tk',
            'tgl_ba_loading_tk',
            'tgl_pricing',
            'real_price',
            'nilai_penjualan',
            'kontrak_qty_ton',
            'real_qty_kg',
            'kapal_tongkang',
            'suhu',
            'buyer',
            'status',
            'lama_loading_hari',
            'real_loading',
            'bulan',
            'bln_name',
            'plan_bln_name',
        ]);

        // Jika ada pencarian, ambil semua data tanpa filter tanggal
        if (!empty($this->search)) {
            // Tidak ada filter tanggal
        } else {
            // Jika ada filter tanggal, gunakan itu
            if ($this->minDate && $this->maxDate) {
                $query->whereDate('real_loading_tk', '>=', $this->minDate)->whereDate('real_loading_tk', '<=', $this->maxDate);
            } elseif ($this->minDate) {
                $query->whereDate('real_loading_tk', '>=', $this->minDate);
            } elseif ($this->maxDate) {
                $query->whereDate('real_loading_tk', '<=', $this->maxDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('real_loading_tk', '>=', \Carbon\Carbon::now()->subDays(30));
            }
        }

        return $query->get()->map(function ($item) {
            return [
                'ggu_sc' => $item->ggu_sc,
                'gum_sc' => $item->gum_sc,
                'plan_loading_tk' => $item->plan_loading_tk,
                'real_loading_tk' => $item->real_loading_tk,
                'tgl_ba_loading_tk' => $item->tgl_ba_loading_tk,
                'tgl_pricing' => $item->tgl_pricing,
                'real_price' => $item->real_price,
                'nilai_penjualan' => $item->nilai_penjualan,
                'kontrak_qty_ton' => $item->kontrak_qty_ton,
                'real_qty_kg' => $item->real_qty_kg,
                'kapal_tongkang' => $item->kapal_tongkang,
                'suhu' => $item->suhu,
                'buyer' => $item->buyer,
                'status' => $item->status,
                'lama_loading_hari' => $item->lama_loading_hari,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'GGU SC',
            'GUM SC',
            'Tanggal Rencana Loading',
            'Tanggal Real Loading',
            'Tanggal BA Loading',
            'Tanggal Pricing',
            'Harga Real',
            'Nilai Penjualan',
            'Kuantiti Kontrak (Ton)',
            'Kuantiti Real (Kg)',
            'Armada',
            'Suhu',
            'Buyer',
            'Lama Hari Loading',
        ];
    }
}
