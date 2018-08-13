<?php

namespace App\Repository\Transaksi;
use DB;

class Kwitansi
{
    protected $conn = "sqlsrv";

    public function getDetail($no_kw)
    {
        // dd($no_kw);
        $data = DB::connection($this->conn)
            ->table('Kwitansi as kw')->select('kw.no_kwitansi','kw.no_bukti','kw.kelompok','kw.harga',
                    'kw.jumlah','kw.tunai','kw.piutang','kw.tagihan','kw.kd_sub_unit','kw.no_rm','status_bayar')
            ->where('kw.no_kwitansi', '=', $no_kw)
            ->get();
        return $data;
    }
}