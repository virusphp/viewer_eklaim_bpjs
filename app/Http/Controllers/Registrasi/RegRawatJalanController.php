<?php

namespace App\Http\Controllers\Registrasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\Sep\Registrasi;
Use DateTime;

class RegRawatJalanController extends Controller
{
    public function index()
    {
        return view('simrs.registrasi.index');
    }

    public function search(Request $request, Registrasi $rj)
    {
        if ($request->ajax()) {
            $no = 1;
            $data = $rj->getSearchRj($request);
            foreach($data as $q) {
                $tgl = new DateTime($q->tgl_reg);
                $query[] = [
                    'no' => $no++,
                    'no_reg' => $q->no_reg,
                    'no_rm' => $q->no_rm,
                    'tgl_reg' => $tgl->format('Y-m-d'),
                    'jns_rawat' => jenisRawat($q->jns_rawat),
                    'no_sjp' => $q->no_sjp,
                    'cara_bayar' => caraBayar($q->kd_cara_bayar)
                ];
            }
            $result = isset($query) ? ['data' => $query] : ['data' => 0];
            return json_encode($result);
        }
    }
}