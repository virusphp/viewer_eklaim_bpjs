<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\AsalPasien\AsalPasien;

class AsalPasienController extends Controller
{
    //
    protected $ap;

    public function __construct()
    {
        $this->ap = new AsalPasien();
    }

    public function getAsalPasien()
    {
        $asalPasien = $this->ap->getAsalPasien();
        $aPasien="<option value=''>-- Asal Pasien --</pilih>";
        foreach($asalPasien as $key => $val)
        {
            $aPasien.= "<option value='".trim($val->kd_asal_pasien)."'>$val->keterangan</option>";
        }
        return $aPasien;
    }
}
