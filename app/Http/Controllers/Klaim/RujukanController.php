<?php

namespace App\Http\Controllers\Klaim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\Rujukan;

class RujukanController extends Controller
{
    public function getRujukanInternal(Request $request, Rujukan $rujukan)
    {
        $data = $request->all();
        $getRujukan = $rujukan->getRujukan($data); 
        return response()->json($getRujukan);
    }


    public function getNoSurat(Request $request, Rujukan $rujukan)
    {
        if ($request->ajax()) {
            $req = $request->all();
            $result = $rujukan->getNoSurat($req); 
            // dd($result);
            return json_encode($result);
        }
    }

    public function getsdf(Request $req)
    {
        if ($req->ajax()) {
            $kode     = $req->get('term');
            $diagnosa = $this->Diagnosa($kode);
            $data     = json_decode($diagnosa);
            $diagAwal = $data->response->diagnosa;
            return $diagAwal;
        }
    }
}