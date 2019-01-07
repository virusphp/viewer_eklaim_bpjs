<?php

namespace App\Repository\Registrasi;
use DB;

class Registrasi
{
    protected $conn = "sqlsrv";

    public function getData($request)
    {
        $today = date('Y-m-d');
        $data = DB::table('Registrasi')->select('no_reg','no_rm','tgl_reg','no_sjp')
            ->where(function($query) use ($request){
                if (( $request->only('search')) ) 
                {
                     $keywords = isset($request->search) ? '%'. $request->search . '%' : '';
                     $query->orWhere('no_rm','LIKE', $keywords);
                     $query->orWhere('nama_pasien','LIKE', $keywords);
                } else if($request->only('tgl')) {
                    $tgl = date('Y-m-d', strtotime($request->tgl));
                    $query->orWhere('tgl_reg','=',$tgl);
                } else {
                    $query->orWhere('tgl_reg','=', $today);
                }
            })
            ->paginate(10);
        return $data;
    }

    public function getSearch($request)
    {
        // dd($request->all());
        $tgl = date('Y-m-d', strtotime($request->tgl_reg));
        $data = DB::table('Registrasi')->select('no_reg','no_rm','tgl_reg','kd_cara_bayar',
                    'jns_rawat','no_sjp')
            ->where(function($query) use ($request) {
                $tgl = date('Y-m-d', strtotime($request->tgl_reg));
                if (($request->search == null) && ($request->kd_cara_bayar == null)) {
                    $query->orWhere([
                        ['jns_rawat','=',$request->jns_rawat],
                        ['tgl_reg','=',$tgl]
                    ]);
                } else if ($request->search == null) {
                    $query->orWhere([
                        ['jns_rawat','=',$request->jns_rawat],
                        ['kd_cara_bayar','=',$request->kd_cara_bayar],
                        ['tgl_reg','=',$tgl]
                    ]);
                } else if ($request->kd_cara_bayar == null) {
                    $term = $request->get('search');
                    $keywords = '%'. $term .'%';
                    $query->orWhere([
                        ['jns_rawat','=',$request->jns_rawat],
                        ['tgl_reg','=',$tgl],
                        ['no_rm','LIKE',$keywords]
                    ]);
                } else {
                    $term = $request->get('search');
                    $keywords = '%'. $term .'%';
                    $query->orWhere([
                        ['jns_rawat','=',$request->jns_rawat],
                        ['kd_cara_bayar','=',$request->kd_cara_bayar],
                        ['tgl_reg','=',$tgl],
                        ['no_rm','LIKE',$keywords]
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
                if (($request->search == null) && ($request->kd_cara_bayar == null)) {
                    $query->orWhere([
                        ['r.tgl_reg','=',$tgl],
                        ['r.jns_rawat','=',1]
                    ]);
                } else if ($request->kd_cara_bayar == null) {
                    $term = $request->get('search');
                    $keywords = '%'. $term . '%';
                    $query->orWhere([
                        ['r.jns_rawat','=',1],
                        ['r.tgl_reg','=',$tgl],
                        ['r.no_rm', 'LIKE', $keywords]
                    ]);
                } else {
                    $term = $request->get('search');
                    $keywords = '%'. $term . '%';
                    $query->orWhere([
                        ['r.jns_rawat','=',1],
                        ['r.kd_cara_bayar','=',$request->kd_cara_bayar],
                        ['r.tgl_reg','=',$tgl],
                        ['r.no_rm', 'LIKE', $keywords]
                    ]);
                }
            })        
            ->get();
        return $data;
    }

    public function getSearchRi($request)
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
                if (($request->search == null) && ($request->kd_cara_bayar == null)) {
                    $query->orWhere([
                        ['r.tgl_reg','=',$tgl],
                        ['r.jns_rawat','=',2]
                    ]);
                } else if ($request->kd_cara_bayar == null) {
                    $term = $request->get('search');
                    $keywords = '%'. $term . '%';
                    $query->orWhere([
                        ['r.jns_rawat','=',2],
                        ['r.tgl_reg','=',$tgl],
                        ['r.no_rm', 'LIKE', $keywords]
                    ]);
                } else {
                    $term = $request->get('search');
                    $keywords = '%'. $term . '%';
                    $query->orWhere([
                        ['r.jns_rawat','=',2],
                        ['r.kd_cara_bayar','=',$request->kd_cara_bayar],
                        ['r.tgl_reg','=',$tgl],
                        ['r.no_rm', 'LIKE', $keywords]
                    ]);
                }
            })        
            ->get();
        return $data;
    }
}