<?php

namespace App\Repository\Sep;
use DB;

class Registrasi
{
    protected $conn = "sqlsrv";

    public function getRegister($noReg)
    {
        return DB::table('registrasi as r')->select('r.tgl_reg','r.no_sjp','pp.no_kartu','kd_asal_pasien')
            ->join('penjamin_pasien as pp', function($join){
                $join->on('r.no_rm', '=','pp.no_rm')
                    ->on('r.kd_penjamin','=','pp.kd_penjamin');
            })
            ->where('r.no_reg','=', $noReg)
            ->first();
    }

    public function getRawatInap($noReg)
    {
        return DB::table('rawat_inap as ri')
            ->select('ri.no_reg','ri.no_rm','p.alamat','p.nama_pasien','p.no_telp','p.nik','p.tgl_lahir','pg.nama_pegawai')
            ->join('pasien as p', function($join) {
                $join->on('ri.no_rm','=','p.no_rm');
            })
            ->join('pegawai as pg', function($join) {
                $join->on('ri.kd_dokter','=','pg.kd_pegawai');
            })
            ->join('tempat_tidur as tt',function($join){
                $join->on('ri.kd_tempat_tidur','=','tt.kd_tempat_tidur')
                    ->join('kamar as k', function($join) {
                        $join->on('tt.kd_kamar','=','k.kd_kamar')
                            ->join('sub_unit as su',function($join) {
                                $join->on('k.kd_sub_unit','=','su.kd_sub_unit');
                            });
                    });
            })
            ->where('ri.no_reg', '=', $noReg)
            ->first();
    }

    public function getRawatJalan($noReg)
    {
        return DB::table('rawat_jalan as rj')
            ->select('rj.no_reg','rj.no_rm','p.alamat','p.nama_pasien','p.no_telp','p.nik','p.tgl_lahir', 'su.nama_sub_unit')
            ->join('pasien as p', function($join) {
                $join->on('rj.no_rm','=','p.no_rm');
            })
            ->join('sub_unit as su', function($join) {
                $join->on('rj.kd_poliklinik', '=', 'su.kd_sub_unit');
            })
            ->join('pegawai as pg', function($join) {
                    $join->on('rj.kd_dokter','=','pg.kd_pegawai');
            })
            ->where('rj.no_reg', '=', $noReg)
            ->first();
    }

    public function getRawatDarurat($noReg)
    {
        return DB::table('rawat_darurat as rd')->select('rd.no_reg','rd.no_rm','p.alamat','p.nama_pasien','p.no_telp','p.nik','p.tgl_lahir','pg.nama_pegawai')
            ->join('pasien as p', function($join) {
                $join->on('rd.no_rm','=','p.no_rm');
            })
            ->join('pegawai as pg', function($join) {
                $join->on('rd.kd_dokter', '=','pg.kd_pegawai');
            })
            ->where('rd.no_reg', '=', $noReg)
            ->first();
    }

    public function getNoAntrian($noReg, $kdPoli, $tglReg)
    {
        return DB::select("
        SELECT noantrian FROM (
            SELECT
            ROW_NUMBER() OVER (ORDER BY rj.no_reg ASC) AS noantrian, rj.no_reg, rj.kd_poliklinik
            FROM dbo.Registrasi as r inner join dbo.Rawat_Jalan as rj on r.no_reg=rj.no_reg where rj.kd_poliklinik='".$kdPoli."' and r.tgl_reg = '".formatTgl($tglReg)."'
        )  AS regis_pasien
        WHERE no_reg = '".$noReg."'
        ");
    }

    public function getRujukan($noReg)
    {
        return DB::table('rujukan')->select('kd_instansi')->where('no_reg', $noReg)->first();
    }

    public function getSearch($request)
    {
        // dd($request->all());
        $tgl = date('Y-m-d', strtotime($request->tgl_reg));
        $data = DB::table('registrasi as r')
            ->select('r.no_reg','r.no_rm','r.tgl_reg','r.kd_cara_bayar','r.jns_rawat','r.no_sjp','p.nama_pasien')
            ->join('pasien as p', function($join) {
                $join->on('r.no_rm', '=', 'p.no_rm');
            })
            ->where(function($query) use ($request) {
                $tgl = date('Y-m-d', strtotime($request->tgl_reg));
                if (($request->search == null) && ($request->kd_cara_bayar == null)) {
                    $query->orWhere([
                        ['r.jns_rawat','=',$request->jns_rawat],
                        ['r.tgl_reg','=',$tgl],
                        ['r.status_keluar', '!=', 2]
                    ]);
                } else if ($request->search == null) {
                    $query->orWhere([
                        ['r.jns_rawat','=',$request->jns_rawat],
                        ['r.kd_cara_bayar','=',$request->kd_cara_bayar],
                        ['r.tgl_reg','=',$tgl],
                        ['r.status_keluar', '!=', 2]
                    ]);
                } else if ($request->kd_cara_bayar == null) {
                    $term = $request->get('search');
                    $keywords = '%'. $term .'%';
                    $query->orWhere([
                        ['r.jns_rawat','=',$request->jns_rawat],
                        ['r.tgl_reg','=',$tgl],
                        ['r.no_rm','LIKE',$keywords],
                        ['r.status_keluar', '!=', 2]
                    ]);
                    $query->orWhere([
                        ['r.jns_rawat','=',$request->jns_rawat],
                        ['r.tgl_reg','=',$tgl],
                        ['p.nama_pasien','LIKE',$keywords],
                        ['r.status_keluar', '!=', 2]
                    ]);
                } else {
                    $term = $request->get('search');
                    $keywords = '%'. $term .'%';
                    $query->orWhere([
                        ['r.jns_rawat','=',$request->jns_rawat],
                        ['r.kd_cara_bayar','=',$request->kd_cara_bayar],
                        ['r.tgl_reg','=',$tgl],
                        ['r.no_rm','LIKE',$keywords],
                        ['r.status_keluar', '!=', 2]
                    ]);
                    $query->orWhere([
                        ['r.jns_rawat','=',$request->jns_rawat],
                        ['r.kd_cara_bayar','=',$request->kd_cara_bayar],
                        ['r.tgl_reg','=',$tgl],
                        ['p.nama_pasien','LIKE',$keywords],
                        ['r.status_keluar', '!=', 2]
                    ]);
                }
            })        
            ->get();
        return $data;
    }

    public function getSearchRj($request)
    {
        // dd($request->all());
        $tgl = date('Y-m-d', strtotime($request->tgl_reg));
        $data = DB::table('Registrasi as r')
            ->select('r.no_reg','r.no_rm','r.tgl_reg','r.kd_cara_bayar','r.jns_rawat','r.no_sjp','p.nama_pasien')
            ->join('pasien as p', function($join) {
                $join->on('r.no_rm', '=', 'p.no_rm');
            })
            ->where(function($query) use ($request) {
                $tgl = date('Y-m-d', strtotime($request->tgl_reg));
                if ($request->search == null) {
                    $query->orWhere([
                        ['r.tgl_reg','=',$tgl],
                        ['r.jns_rawat','=',1]
                    ]);
                } else {
                    $term = $request->get('search');
                    $keywords = '%'. $term . '%';
                    $query->orWhere([
                        ['r.jns_rawat','=',1],
                        ['r.tgl_reg','=',$tgl],
                        ['r.no_rm', 'LIKE', $keywords]
                    ]);
                    $query->orWhere([
                        ['r.jns_rawat','=',1],
                        ['r.tgl_reg','=',$tgl],
                        ['p.nama_pasien','LIKE',$keywords]
                    ]);
                }
            })        
            ->get();
        return $data;
    }

    public function getSearchRi($request)
    {
        $tgl = date('Y-m-d', strtotime($request->tgl_reg));
        $data = DB::table('Registrasi as r')
            ->select('r.no_reg','r.no_rm','r.tgl_reg','r.kd_cara_bayar','r.jns_rawat','r.no_sjp','p.nama_pasien')
            ->join('pasien as p', function($join) {
                $join->on('r.no_rm', '=', 'p.no_rm');
            })
            ->where(function($query) use ($request) {
                $tgl = date('Y-m-d', strtotime($request->tgl_reg));
                if ($request->search == null) {
                    $query->orWhere([
                        ['r.tgl_reg','=',$tgl],
                        ['r.jns_rawat','=',2]
                    ]);
                } else {
                    $term = $request->get('search');
                    $keywords = '%'. $term . '%';
                    $query->orWhere([
                        ['r.jns_rawat','=',2],
                        ['r.tgl_reg','=',$tgl],
                        ['r.no_rm', 'LIKE', $keywords]
                    ]);
                    $query->orWhere([
                        ['r.jns_rawat','=',2],
                        ['r.tgl_reg','=',$tgl],
                        ['p.nama_pasien','LIKE',$keywords]
                    ]);
                }
            })        
            ->get();
        return $data;
    }
}