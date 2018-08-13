<?php

namespace App\Http\Controllers\Transaksi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\Transaksi\KwitansiHeader;
use App\Repository\Transaksi\Kwitansi;
use DB;

class KwitansiController extends Controller
{
    public function index(Request $request, KwitansiHeader $kw)
    {
        $kwitansi = $kw->getData($request);
        $route = Route('kwitansi');
        return view('transaksi.kwitansi.index',compact('kwitansi','route'));
    }

    public function getKwitansi(Kwitansi $kw, $no_kwitansi)
    {
        // dd($no_kwitansi);
        $kwitansi = $kw->getDetail($no_kwitansi);
        // dd($kwitansi);
        return view('transaksi.kwitansi.rincian', compact('kwitansi'));
    }
}
