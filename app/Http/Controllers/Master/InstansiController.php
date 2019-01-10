<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\Instansi\Instansi;

class InstansiController extends Controller
{
    protected $insansi;

    public function __construct()
    {
        $this->instansi = new Instansi();
    }

    public function getNamaInstansi()
    {
        $instansi = $this->instansi->getAsalPasien();
        $kdInstansi="<option value=''>-- Nama Instansi --</pilih>";
        foreach($instansi as $key => $val)
        {
            $kdInstansi.= "<option value='".trim($val->kd_instansi)."'>$val->nama_instansi</option>";
        }
        return $kdInstansi;
    }
}
