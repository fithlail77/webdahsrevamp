<?php

namespace App\Exports;

use App\Models\Pupukrawat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PupukExport implements FromCollection, WithHeadings
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
        $query = Pupukrawat::select([
            'issue_no',
            'material_code',
            'material_name',
            'unit',
            'issue_qty',
            'issue_date',
            'posting_date',
            'storage_location',
            'description',
            'estate',
            'div',
            'block1',
            'block2',
            'years',
            'tm_tbm',
            'sap_issue_no',
            'kelompok',
            'jenis_pupuk',
            'system_aplikasi',
            'bln',
            'tahun',
            'estate2',
            'divisi',
            'status2',
            'areal',
            'blok',
            'tt',
            'programs',
            'dosis',
            'jumlah_pokok',
            'ha',
            'harga',
            'biaya',
        ]);

        // Jika ada pencarian, ambil semua data tanpa filter tanggal
        if (!empty($this->search)) {
            // Tidak ada filter tanggal
        } else {
            // Jika ada filter tanggal, gunakan itu
            if ($this->minDate && $this->maxDate) {
                $query->whereDate('issue_date', '>=', $this->minDate)->whereDate('issue_date', '<=', $this->maxDate);
            } elseif ($this->minDate) {
                $query->whereDate('issue_date', '>=', $this->minDate);
            } elseif ($this->maxDate) {
                $query->whereDate('issue_date', '<=', $this->maxDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('issue_date', '>=', \Carbon\Carbon::now()->subDays(30));
            }
        }

        return $query->get()->map(function ($item) {
            return [
                'issue_no' => $item->issue_no,
                'material_code' => $item->material_code,
                'material_name' => $item->material_name,
                'unit' => $item->unit,
                'issue_qty' => $item->issue_qty,
                'issue_date' => \Carbon\Carbon::parse($item->issue_date)->format('d-m-Y'),
                'posting_date' => \Carbon\Carbon::parse($item->posting_date)->format('d-m-Y'),
                'storage_location' => $item->storage_location,
                'description' => $item->description,
                'estate' => $item->estate,
                'div' => $item->div,
                'block1' => $item->block1,
                'block2' => $item->block2,
                'years' => $item->years,
                'tm_tbm' => $item->tm_tbm,
                'sap_issue_no' => $item->sap_issue_no,
                'kelompok' => $item->kelompok,
                'jenis_pupuk' => $item->jenis_pupuk,
                'system_aplikasi' => $item->system_aplikasi,
                'bln' => $item->bln,
                'tahun' => $item->tahun,
                'estate2' => $item->estate2,
                'divisi' => $item->divisi,
                'status2' => $item->status2,
                'areal' => $item->areal,
                'blok' => $item->blok,
                'tt' => $item->tt,
                'programs' => $item->programs,
                'dosis' => $item->dosis,
                'jumlah_pokok' => $item->jumlah_pokok,
                'ha' => $item->ha,
                'harga' => $item->harga,
                'biaya' => $item->biaya,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Issued No',
            'Material Code',
            'Material Name',
            'Unit',
            'Issued Qty',
            'Issued Date',
            'Posting Date',
            'Storage Location',
            'Description',
            'Estate',
            'Div',
            'Block1',
            'Block2',
            'Years',
            'TM/TBM',
            'SAP Issued No',
            'Kelompok',
            'Jenis Pupuk',
            'System Aplikasi',
            'Bln',
            'Tahun',
            'Estate2',
            'Divisi',
            'Status2',
            'Areal',
            'Blok', 
            'TT', 
            'Programs', 
            'Dosis', 
            'Jumlah Pokok', 
            'Ha', 
            'Harga',
            'Biaya' 
        ];
    }
}
