<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Poli\Poli;

class PoliController extends Controller
{
    public function getPoli(Request $req, Poli $poli)
    {
        if ($req->ajax()) {
            $dataPoli = $poli->getPoli();
            $data = json_decode($dataPoli, true);
            $poli="<option value='0'>--Silahkan Pilih poli--</pilih>";
            foreach($data as $d)
            {
                $poli.= "<option value='$d[kd_sub_unit]'>$d[nama_sub_unit]</option>";
            }
            return $poli;
        }
    }

    public function getHarga(Request $req, Poli $poli)
    {
        if ($req->ajax()) {
            $request = $req->kdPoli;
            $data = $poli->getHarga($request);
            return $data;
        }
    }

    public function getDokter(Request $req, Poli $poli)
    {
        if ($req->ajax()) {
            $request = $req->kdPoli;
            $data = $poli->getDokter($request);
            return $data;
        }
    }
}
