<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Poli\Poli;

class PoliController extends Controller
{
    public function getPoliback(Request $req, Poli $poli)
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

    public function getPoli(Request $req, Poli $poli)
    {
        // dd($req->all());
        if ($req->ajax()) {
            $kode = $req->get('term');
            $poli = $poli->getPoli($kode);
            $data = json_decode($poli);
            // dd($data);
            $diagAwal = $data->hasil->poli;
            return $diagAwal;
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
            $dataDokter = $poli->getDokter($request);
            $data = json_decode($dataDokter);
            // dd($data->hasil);
            foreach($data->hasil as $d)
            {
                $dokter = "<option value='$d->Kd_Pegawai'>$d->nama_pegawai</option>";
            }
            return $dokter;
        }
    }
}
