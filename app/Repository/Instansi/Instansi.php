<?php

namespace App\Repository\Instansi;
use DB;

class Instansi
{
    public function getAsalPasien()
    {
        return DB::table('instansi_rujukan')->select('kd_instansi', 'nama_instansi')->get();
    }
}