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
}