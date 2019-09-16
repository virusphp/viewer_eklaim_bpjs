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

    public function getNoSurat($data)
    {
        $dari = date('Y-m-d', strtotime('-90 days', strtotime($data['tglSep'])));
        // dd($noSurat);
        $rujukan = DB::table('Surat_Rujukan_Internal AS ri')
            ->select('ri.No_Rujukan', 'ri.no_rujukan_bpjs')
            ->whereBetween('tgl_rujukan_bpjs', [$dari, $data['tglSep']])
            ->whereRaw('substring(no_rujukan,7,6) = ' . $data['term'] . '')
            ->get();
        // \var_dump($rujukan);
        return $rujukan;
    }

    public function getSurat($data)
    {
        $jenisSurat = explode("/", $data->noSurat);

        $rujukan = DB::table('Surat_Rujukan_internal as ri')
            ->select(
                'ri.no_rujukan',
                'ri.no_rujukan_bpjs',
                'ri.tgl_rujukan',
                'ri.tgl_berlaku',
                'ri.kd_icd_bpjs',
                'ri.terapi',
                'ri.kd_sub_unit',
                'ri.tgl_rujukan_bpjs',
                'ri.kd_sub_unit_tujuan_rujuk',
                'ri.kd_dokter',
                'p.nama_pegawai',
                'su.nama_sub_unit'
            )
            ->join('Pegawai as p', function ($join) {
                $join->on('ri.kd_dokter', '=', 'p.kd_pegawai');
            });

        if ($jenisSurat[1] == "SKO" | $jenisSurat[1] == "SRI") {
            // dd("masuk sini");
            $rujukan = $rujukan->join('Sub_Unit as su', function ($join) {
                $join->on('ri.kd_sub_unit_tujuan_rujuk', '=', 'su.kd_sub_unit');
            })
            ->where([
                ['ri.no_rujukan', '=', $data->noSurat],
                ['ri.no_rujukan_bpjs', '=', $data->noRujukan]
            ])
            ->first();
        } else {
            $rujukan = $rujukan->join('Sub_Unit as su', function ($join) {
                $join->on('ri.kd_sub_unit', '=', 'su.kd_sub_unit');
            })
            ->where([
                ['ri.no_rujukan', '=', $data->noSurat],
                ['ri.no_rujukan_bpjs', '=', $data->noRujukan]
            ])
            ->first();
        }

        return $rujukan;
    }

    public function getSurat2($noSurat, $rujukan)
    {
        $dari = date('Y-m-d', strtotime('-90 days', strtotime(date('Y-m-d'))));
        // dd($noSurat);
        $rujukan = DB::table('Surat_Rujukan_Internal AS ri')
        ->select(
            'ri.no_rujukan',
            'ri.no_rujukan_bpjs',
            'ri.tgl_rujukan',
            'ri.tgl_berlaku',
            'ri.kd_icd_bpjs',
            'ri.terapi',
            'ri.kd_sub_unit',
            'ri.tgl_rujukan_bpjs',
            'ri.kd_sub_unit_tujuan_rujuk',
            'ri.kd_dokter',
            'p.nama_pegawai'
        )
        ->join('Pegawai as p', function ($join) {
            $join->on('ri.kd_dokter', '=', 'p.kd_pegawai');
        })
        ->whereBetween('tgl_rujukan_bpjs', [$dari, date('Y-m-d')])
        ->whereRaw('substring(no_rujukan,7,6) = ' . $noSurat . '')
        ->first();
        // \var_dump($rujukan);
        return $rujukan;
    }
}
