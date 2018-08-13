<?php

namespace App\Repository\Transaksi;
use DB;

class KwitansiHeader
{
    protected $conn = "sqlsrv";

    public function getData($request)
    {
        $data = DB::connection($this->conn)
            ->table('Kwitansi_Header as kh')->select('kh.no_kwitansi','kh.nama_pasien','kh.untuk',
                    'kh.tagihan')
            ->where(function($query) use ($request){
                if (($term = $request->get('search')) ) 
                {
                     $keywords = '%'. $term .'%';
                     $query->where('kh.no_kwitansi','=', $term);
                     $query->orWhere('kh.no_surat', $term);
                } 
            })
            ->paginate(10);
        return $data;
    }
}