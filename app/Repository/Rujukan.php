<?php
namespace App\Repository;

use DB;

class Rujukan 
{
    public function getRujukan($rujukan)
    {
        // return $data;
        $data = DB::table('Surat_Rujukan_Internal')->where('no_rujukan_bpjs', '=', $rujukan['internal'])->get();
        return $data;
    }

    public function getNoSurat($noSurat)
    {
        $data = DB::table('Surat_Rujukan_Internal')
                    ->select('no_rujukan','no_reg','no_rujukan_bpjs','jenis_surat','kd_dokter')
                    ->where('no_rujukan_bpjs', '=', $noSurat['noRujukan'])
                    ->get();
        return $data;
    }
}