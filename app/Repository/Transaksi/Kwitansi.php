<?php

namespace App\Repository\Transaksi;
use DB;

class Kwitansi
{
    protected $conn = "sqlsrv";

    public function getDetail($no_kw)
    {
        $data = DB::connection($this->conn)
            ->table('Kwitansi')->select('no_kwitansi','no_bukti','kelompok','harga',
                    'jumlah','tunai','piutang','tagihan','status_bayar')
            ->where('no_kwitansi', '=', $no_kw)
            ->get();
        return $data;
    }
}