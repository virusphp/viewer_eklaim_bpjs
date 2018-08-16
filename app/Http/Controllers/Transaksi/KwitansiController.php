<?php

namespace App\Http\Controllers\Transaksi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\Transaksi\KwitansiHeader;
use App\Repository\Transaksi\Kwitansi;
use DB;
use Validator;

class KwitansiController extends Controller
{
    public function index(Request $request, KwitansiHeader $kw)
    {
        if ($request->only('tgl')) {
            $rules = [
                'tgl' => 'required'
            ];
            $costumMessage = [
                'tgl.required' => 'Tanggal harus di isi'
            ];
            $this->validate($request,$rules, $costumMessage);
        }         
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
