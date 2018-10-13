<?php

namespace App\Repository\Sep;
use DB;

class User
{
    protected $conn = "sqlsrv";

    public function getSearch($request)
    {
        // dd($request->all());
        $tgl = date('Y-m-d', strtotime($request->tgl_reg));
        $data = DB::table('user_login_sep')->select('kd_pegawai','nama_pegawai','tgl_create','role')
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

}