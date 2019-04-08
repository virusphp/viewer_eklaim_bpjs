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
        $data = DB::table('Surat_Rujukan_Internal as sri')
                    ->select('sri.no_rujukan','sri.no_reg','sri.no_rujukan_bpjs','sri.jenis_surat','p.nama_pegawai', 'su.kd_poli_dpjp')
                    ->join('Sub_Unit as su', 'sri.kd_sub_unit','=','su.kd_sub_unit')
                    ->join('Pegawai as p', 'sri.kd_dokter','=', 'p.kd_pegawai')
                    ->where('no_rujukan_bpjs', '=', $noSurat['noRujukan'])
                    ->orderBy('sri.no_rujukan', 'desc')
                    ->get();
        return $data;
    }
}