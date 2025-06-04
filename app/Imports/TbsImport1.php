<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection,


class TbsImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        //
    }
    //public function model(array $row)
   // {
        //return new Tbsinternal([
        //    'angkutan' => $row['angkutan'],
        //    'notiket' => $row['notiket'],
        //    'tgltiket' => $row['tgltiket'],
        //    'nosptbs' => $row['nosptbs'],
        //    'tglsptbs' => $row['tglsptbs'],
        //    'tglpanen' => $row['tglpanen'],
        //    'supir' => $row['supir'],
        //    'nopol' => $row['nopol'],
        //    'jammasuk' => $row['jammasuk'],
        //    'jamkeluar' => $row['jamkeluar'],
        //    'estate' => $row['estate'],
        //    'divisi' => $row['divisi'],
        //    'blok' => $row['blok'],
        //    'tt' => $row['tt'],
        //    'lahan' => $row['lahan'],
        //    'jmltandan' => $row['jmltandan'],
        //    'brondolan' => $row['brondolan'],
        //    'bruto' => $row['bruto'],
        //    'tara' => $row['tara'],
        //    'netto' => $row['netto'],
        //    'grading' => $row['grading'],
        //    'netbersih' => $row['netbersih'],
        //    'bjr' => $row['bjr'],
        //    'sortase' => $row['sortase'],
        //    'f0' => $row['f0'],
        //    'f00' => $row['f00'],
        //    'f14' => $row['f14'],
        //    'f5' => $row['f5'],
        //    'f6' => $row['f6'],
        //    'tankos' => $row['tankos'],
        //    'tkpanjang' => $row['tkpanjang'],
        //    'grdbrondolan' => $row['grdbrondolan'],
        //    'sampah' => $row['sampah'],
        //    'kastrasi' => $row['kastrasi'],
        //    'noramp' => $row['noramp'],
        //    'jarak' => $row['jarak'],
        //    'tarif' => $row['tarif'],
        //]);
    //}
}
