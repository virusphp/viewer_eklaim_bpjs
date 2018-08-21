<?php

namespace App\Repository\Transaksi;
use DB;

class Kwitansi
{
    protected $conn = "sqlsrv";

    public function getDetail($no_kw)
    {
        $debet = $this->getDebet($no_kw);
        $kredit = $this->getCoba($no_kw);
        $data = array_merge($debet, $kredit);
        // dd($data);
        return $data;
    }

    public function getDebet($no_kw)
    {
        $data = DB::connection($this->conn)
            ->table('Kwitansi_Header as kw')
            ->select('kw.tagihan as debet','kw.untuk')
            ->where('kw.no_kwitansi', '=', $no_kw)
            ->get();

        $debet = [];
        foreach($data as $key => $val)
        {
            $debet[] = $val;
            $debet[$key]->no_perkiraan = "111010101";
            $debet[$key]->nama_perkiraan = "Kas di Bendahara Penerimaan";
            $debet[$key]->kredit = 0;
        }
        // dd($debet);
        return $debet;
    }

    public function getKredit($no_kw)
    {
        $data = DB::connection($this->conn)
            ->table('Kwitansi as kh')
            ->select('ap.no_perkiraan','ap.nama_perkiraan')
            ->join('Akun_Perkiraan_Tarif as atp', function($join) {
                $join->on('kh.kd_sub_unit','=','atp.kd_sub_unit')
                    ->join('Akun_Perkiraan as ap', function($join) {
                        $join->on('atp.no_perkiraan2', '=', 'ap.no_perkiraan');
                    });
                        // ->groupBy('atp.no_perkiraan2');
            })
            ->join('Kwitansi_Header as kw', function($join) {
                $join->on('kh.no_kwitansi', '=','kw.no_kwitansi');
            })
            ->groupBy('ap.no_perkiraan','ap.nama_perkiraan')
            ->where('kh.no_kwitansi', '=', $no_kw)
            ->get();
            // dd($data);
        $kredit = [];
        foreach($data as $key => $val)
        {
            $kredit[] = $val;
            $kredit[$key]->debet = 0;
        }
        // dd($kredit);
        return $kredit;
    }

    public function getCoba($no_kw)
    {
        $data = DB::connection($this->conn)
            ->table('Kwitansi_Header as kh')
            ->select('kw.no_kwitansi','kh.untuk','kw.no_bukti', DB::raw('sum(kw.tagihan) as kredit'), 'tp.kd_tarif', 'ap.no_perkiraan','ap.nama_perkiraan')
            ->join('Kwitansi as kw', function($join){
                $join->on('kh.no_kwitansi','=','kw.no_kwitansi')
                    ->join('Tagihan_Pasien as tp', function($join){
                        $join->on('kw.no_bukti','=','tp.no_bukti')
                            ->join('Akun_Perkiraan_Tarif as apt',function ($join){
                                $join->on('tp.kd_tarif','=','apt.kd_tarif');
                                $join->on('tp.kd_sub_unit', '=', 'apt.kd_sub_unit')
                                    ->join('Akun_Perkiraan as ap', function($join) {
                                        $join->on('apt.no_perkiraan2','=', 'ap.no_perkiraan');
                                    });
                            });
                    });
            })
            ->where('kw.no_kwitansi','=',$no_kw)
            ->groupBy('kh.untuk','kw.no_bukti','tp.kd_tarif','kw.no_kwitansi', 'ap.no_perkiraan','ap.nama_perkiraan')
            ->get();

        // $coba = json_decode($data, true);
        $kredit = [];
        foreach($data as $key => $val) {
            $key1 = $val->no_perkiraan;
            $key2 = $val->nama_perkiraan;
            $key3 = $val->untuk;
            $key4 = $val->kredit;
            $key5 = $val->no_kwitansi;
            unset($val->no_bukti, $val->kd_tarif, $val->no_kwitansi);
            $kredit[$key1] = $val;
            $kredit[$key1]->debet = 0;
        }
        return $kredit;
    }
}