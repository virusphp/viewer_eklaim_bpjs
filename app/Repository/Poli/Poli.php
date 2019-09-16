<?php

namespace App\Repository\Poli;
use DB;

class Poli
{
    public function getPoliklinik($noReg)
    {
        return DB::table('rawat_jalan as rj')->select('su.nama_sub_unit as nama_klinik','rj.kd_poliklinik')
        ->join('sub_unit as su', function($join) {
            $join->on('rj.kd_poliklinik', '=', 'su.kd_sub_unit');  
        })
        ->where('no_reg', '=', $noReg)
        ->first();
    }
}