<?php

namespace App\Repository\Transaksi;
use DB;

class KwitansiHeader
{
    protected $conn = "sqlsrv";

    public function getData($request)
    {
        $today = date('Y-m-d');
        $data = DB::connection($this->conn)
            ->table('Kwitansi_Header')->select('no_kwitansi','tgl_kwitansi','untuk',
                    'tagihan')
            ->where(function($query) use ($request){
                if (( $request->only('search')) ) 
                {
                     $keywords = isset($request->search) ? '%'. $request->search . '%' : '';
                     $query->orWhere('no_kwitansi','LIKE', $keywords);
                     $query->orWhere('nama_pasien','LIKE', $keywords);
                } else if($request->only('tgl')) {
                    $tgl = date('Y-m-d', strtotime($request->tgl));
                    $query->orWhere('tgl_kwitansi','=',$tgl);
                } else {
                    $query->orWhere('tgl_kwitansi','=', date('Y-m-d'));
                }
            })
            ->paginate(10);
        return $data;
    }
}