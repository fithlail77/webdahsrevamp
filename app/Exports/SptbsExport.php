<?php

namespace App\Exports;

use App\Models\SptbsInput;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class SptbsExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;
    protected $userEstate;

    public function __construct($startDate = null, $endDate = null, $userEstate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->userEstate = $userEstate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = SptbsInput::select([
            'angkutan',
            'no_tiket',
            'tanggal_tiket',
            'no_sptbs',
            'tanggal_sptbs',
            'tanggal_panen',
            'nama_supir',
            'no_polisi',
            'jam_masuk',
            'jam_keluar',
            'estate',
            'divisi',
            'blok',
            'tahun_tanam',
            'lahan',
            'jumlah_tandan',
            'berondolan',
            'berat_bruto',
            'berat_tarra',
            'berat_netto',
            'jumlah_grading',
            'berat_bersih',
            'bjr',
        ]);

        // Filter berdasarkan estate user
        if ($this->userEstate && $this->userEstate !== 'all') {
            $query->where('estate', $this->userEstate);
        }

        // Jika ada pencarian, ambil semua data tanpa filter tanggal
        if (!empty($this->search)) {
            // Tidak ada filter tanggal
        } else {
            // Jika ada filter tanggal, gunakan itu
            if ($this->startDate && $this->endDate) {
                $query->whereDate('tanggal_tiket', '>=', $this->startDate)->whereDate('tanggal_tiket', '<=', $this->endDate);
            } elseif ($this->startDate) {
                $query->whereDate('tanggal_tiket', '>=', $this->startDate);
            } elseif ($this->endDate) {
                $query->whereDate('tanggal_tiket', '<=', $this->endDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('tanggal_tiket', '>=', \Carbon\Carbon::now()->subDays(30));
            }
        }

        return $query->get()->map(function ($item) {
            return [
                'angkutan' => $item->angkutan,
                'no_tiket' => $item->no_tiket,
                'tanggal_tiket' => \Carbon\Carbon::parse($item->tanggal_tiket)->format('d-m-Y'),
                'no_sptbs' => $item->no_sptbs,
                'tanggal_sptbs' => \Carbon\Carbon::parse($item->tanggal_sptbs)->format('d-m-Y'),
                'tanggal_panen' => \Carbon\Carbon::parse($item->tanggal_panen)->format('d-m-Y'),
                'nama_supir' => $item->nama_supir,
                'no_polisi' => $item->no_polisi,
                'jam_masuk' => $item->jam_masuk,
                'jam_keluar' => $item->jam_keluar,
                'estate' => $item-> estate,
                'divisi' => $item->divisi,
                'blok' => $item->blok,
                'tahun_tanam' => $item->tahun_tanam,
                'lahan' => $item->lahan,
                'jumlah_tandan' => $item->jumlah_tandan,
                'berondolan' => $item->berondolan,
                'berat_bruto' => $item->berat_bruto,
                'berat_tarra' => $item->berat_tarra,
                'berat_netto' => $item->berat_netto,
                'jumlah_grading' => $item->jumlah_grading,
                'berat_bersih' => $item->berat_bersih,
                'bjr' => $item->bjr,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Angkutan',
            'No Tiket',
            'Tanggal Tiket',
            'No SPTBS',
            'Tanggal SPTBS',
            'Tanggal Panen',
            'Nama Supir',
            'No Polisi',
            'Jam Masuk',
            'Jam Keluar',
            'Estate',
            'Divisi',
            'Blok',
            'Tahun Tanam',
            'Jenis Lahan',
            'Jumlah Tandan',
            'Berondolan',
            'Berat Bruto',
            'Berat Tarra',
            'Berat Netto',
            'Jumlah Grading',
            'Berat Bersih',
            'BJR'
        ];
    }
}
