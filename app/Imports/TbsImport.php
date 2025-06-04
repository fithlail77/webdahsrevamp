<?php

namespace App\Imports;

use App\Models\Tbsinternal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TbsImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        //dd($collection);
        $indexKe = 1;
        foreach ($collection as $row) {
            if ($indexKe > 1) {
                $data['angkutan'] = $row[0];
                $data['notiket'] = $row[1];
                $data['tgltiket'] = $row[2];
                $data['nosptbs'] = $row[3];
                $data['tglsptbs'] = $row[4];
                $data['tglpanen'] = $row[5];
                $data['supir'] = $row[6];
                $data['nopol'] = $row[7];
                $data['jammasuk'] = $row[8];
                $data['jamkeluar'] = $row[9];
                $data['estate'] = $row[10];
                $data['divisi'] = $row[11];
                $data['blok'] = $row[12];
                $data['tt'] = $row[13];
                $data['lahan'] = $row[14];
                $data['jmltandan'] = $row[15];
                $data['brondolan'] = $row[16];
                $data['bruto'] = $row[17];
                $data['tara'] = $row[18];
                $data['netto'] = $row[19];
                $data['grading'] = $row[20];
                $data['netbersih'] = $row[21];
                $data['bjr'] = $row[22];
                $data['sortase'] = $row[23];
                $data['f0'] = $row[24];
                $data['f00'] = $row[25];
                $data['f14'] = $row[26];
                $data['f5'] = $row[27];
                $data['f6'] = $row[28];
                $data['tankos'] = $row[29];
                $data['tkpanjang'] = $row[30];
                $data['grdbrondolan'] = $row[31];
                $data['sampah'] = $row[32];
                $data['kastrasi'] = $row[33];
                $data['noramp'] = $row[34];
                $data['jarak'] = $row[35];
                $data['tarif'] = $row[36];

                Tbsinternal::create($data);
            }
            $indexKe++;
        }
    }
}
