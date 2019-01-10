<?php

namespace App\Repository\AsalPasien;
use DB;

class AsalPasien
{
    public function getAsalPasien()
    {
        return DB::table('asal_pasien')->select('kd_asal_pasien', 'keterangan')->get();
    }
}