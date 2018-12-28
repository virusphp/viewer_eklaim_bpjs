<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Pasien\Pasien;

class PenjaminController extends Controller
{
    public function getJnsPenjamin(Request $req, Pasien $ps)
    {
        if ($req->ajax()) {
            $kode = $req->get('term');
            $penjamin = $ps->getJnsPenjamin($kode);
            $data = json_decode($penjamin);
            $data = $data->hasil->penjamin;
            return $data;
        }
    }
}
