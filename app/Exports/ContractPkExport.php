<?php

namespace App\Exports;

use App\Models\Contractpk;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ContractPkExport implements FromCollection, WithHeadings
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
        $query = Contractpk::select([
            'ltc',
            'nomor_sc',
            'bln_name',
            'date_pricing',
            'price',
            'dicount_ggu',
            'real_price',
            'dp_date',
            'rencana_awal_kirim',
            'rencana_closed_kirim',
            'actual_awal_kirim',
            'actual_closed_kirim',
            'qty_kontrak_kg',
            'buyer',
            'status',
            'real_qty_kg',
            'buyer_received_qty_kg',
            'rp',
            'keterangan',
            'bulan',
        ]);

        // Jika ada pencarian, ambil semua data tanpa filter tanggal
        if (!empty($this->search)) {
            // Tidak ada filter tanggal
        } else {
            // Jika ada filter tanggal, gunakan itu
            if ($this->minDate && $this->maxDate) {
                $query->whereDate('date_pricing', '>=', $this->minDate)->whereDate('date_pricing', '<=', $this->maxDate);
            } elseif ($this->minDate) {
                $query->whereDate('date_pricing', '>=', $this->minDate);
            } elseif ($this->maxDate) {
                $query->whereDate('date_pricing', '<=', $this->maxDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('date_pricing', '>=', \Carbon\Carbon::now()->subDays(30));
            }
        }

        return $query->get()->map(function ($item) {
            return [
                'ltc' => $item->ltc,
                'nomor_sc' => $item->nomor_sc,
                'bln_name' => $item->bln_name,
                'date_pricing' => $item->date_pricing,
                'price' => $item->price,
                'dicount_ggu' => $item->dicount_ggu,
                'real_price' => $item->real_price,
                'dp_date' => $item->dp_date,
                'rencana_awal_kirim' => $item->rencana_awal_kirim,
                'rencana_closed_kirim' => $item->rencana_closed_kirim,
                'actual_awal_kirim' => $item->actual_awal_kirim,
                'actual_closed_kirim' => $item->actual_closed_kirim,
                'qty_kontrak_kg' => $item->qty_kontrak_kg,
                'buyer' => $item->buyer,
                'status' => $item->status,
                'real_qty_kg' => $item->real_qty_kg,
                'buyer_received_qty_kg' => $item->buyer_received_qty_kg,
                'rp' => $item->rp,
                'keterangan' => $item->keterangan,
                'bulan' => $item->bulan,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'LTC',
            'Nomor SC',
            'Bulan',
            'Tanggal Pricing',
            'Harga',
            'Diskon GGU',
            'Harga Real',
            'Tanggal DP',
            'Rencana Awal Kirim',
            'Rencana Closed Kirim',
            'Actual Awal Kirim',
            'Actual Akhir Kirim',
            'Quntiti KOntrak (KG)',
            'Pembeli',
            'Status',
            'Quntiti Real (KG)',
            'Quntiti Diterima Pembeli (KG)',
            'RP',
            'Keterangan',
            'Bulan',
        ];
    }
}
