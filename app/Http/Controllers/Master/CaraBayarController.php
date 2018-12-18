<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Carabayar\CaraBayar;

class CarabayarController extends Controller
{
    public function getJnsPasienBack(Request $req, CaraBayar $cb)
    {
        if ($req->ajax()) {
            $dataBayar = $cb->getCaraBayar();
            $data = json_decode($dataBayar);
            // dd($data);
            $carabayar="<option value='0'>--Silahkan Pilih cara bayar--</pilih>";
            foreach($data->data as $d)
            {
                $carabayar.= "<option value='$d->kd_cara_bayar'>$d->keterangan</option>";
            }
            return $carabayar;
        }
    }

    public function getJnsPasien(Request $req, CaraBayar $cb)
    {
        // dd($req->all());
        if ($req->ajax()) {
            $kode = $req->get('term');
            $caraBayar = $cb->getBayar($kode);
            $data = json_decode($caraBayar);
            // dd($data);
            $data = $data->hasil->carabayar;
            return $data;
        }
    }
}
