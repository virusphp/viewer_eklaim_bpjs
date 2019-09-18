<?php

namespace App\Repository\Sep;
use DB;

Class Eklaim
{
    public function getView($request)
    {
        // dd($request->search);
        $data = DB::table('sep_claim as sc')
            ->select('sc.no_reg','sc.no_sep','sc.no_rm','sc.tgl_sep','sc.file_claim', 'p.nama_pasien')
            ->join('pasien as p','sc.no_rm','=','p.no_rm')
            ->where(function ($query) use ($request) {
                $tgl = date('Y-m-d', strtotime($request->tgl_sep));
                if ($request->search == null) {
                    $query->orWhere([
                        ['sc.jns_pelayanan', '=', $request->jns_rawat],
                        // ['sc.tgl_sep', '=', $tgl]
                    ]);
                } else {
                    $term = $request->get('search');
                    $keywords = '%'. $term .'%';
                    $query->orWhere([
                        ['sc.jns_pelayanan', '=',$request->jns_rawat],
                        // ['sc.tgl_sep', '=', $tgl],
                        ['sc.no_rm', '=', $keywords]
                    ]);
                    $query->orWhere([
                        ['sc.jns_pelayanan', '=',$request->jns_rawat],
                        // ['sc.tgl_sep', '=', $tgl],
                        ['p.nama_pasien', '=', $keywords]
                    ]);
                }
            })->get();

        return $data;
    }
}