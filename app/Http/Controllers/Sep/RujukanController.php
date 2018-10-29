<?php

namespace App\Http\Controllers\Sep;

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
            $no = 1;
            $req = $request->all();
            $rujukan = $rujukan->getNoSurat($req); 
            foreach($rujukan as $key => $val) {
                $query[] = [
                    'no' => $no++,
                    'noSurat' => '
                        <div class="btn-group">
                            <button data-surat="'.$val->no_rujukan.'" id="h-no-surat" value="'.$val->kd_poli_dpjp.'" class="btn btn-sencodary btn-xs btn-cus">'.$val->no_rujukan.'</button>
                        </div> ',
                    'kdPoliDpjp' => $val->kd_poli_dpjp,
                    'noRujukan' => $val->no_rujukan_bpjs,
                    'jnsSurat' => $val->jenis_surat,
                    'namaDokter' => $val->kd_dokter
                ];
            }
            $result = isset($query) ? ['data' => $query] : ['data' => 0];
            // dd($result);
            return json_encode($result);
        }
    }

    public function getOneNoSurat(Request $request, Rujukan $rujukan)
    {
        if ($request->ajax()) {
            $req = $request->all();
            $rujukan = $rujukan->getNoSurat($req);
            return $rujukan;
        }
    }
}