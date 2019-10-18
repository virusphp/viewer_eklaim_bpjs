<?php

namespace App\Repository\Sep;
use DB;

Class Eklaim
{
    public function getView($request)
    {
        // $data  = DB::table('penjamin_pasien')->where('no_rm', "427466")->get();
        // DB::enableQueryLog();
        $data = DB::table('sep_claim as sc')
            ->select('sc.no_reg','sc.no_sep','sc.no_rm','sc.tgl_sep','sc.file_claim', 'p.nama_pasien', 'pp.no_kartu')
            ->join('pasien as p','sc.no_rm','=','p.no_rm')
            ->join('penjamin_pasien as pp', 'sc.no_rm', '=', 'pp.no_rm')
            ->where(function ($query) use ($request) {
                $tgl = date('Y-m-d', strtotime($request->tgl_sep));
                if ($request->search == null) {
                    $query->orWhere([
                        ['sc.jns_pelayanan', '=', $request->jns_rawat],
                        ['sc.tgl_sep', '=', $tgl]
                    ]);
                } else {
                    $term = $request->get('search');
                    $keywords = '%'. $term .'%';
                    // dd($keywords);
                    $query->orWhere([
                        ['sc.jns_pelayanan', '=',$request->jns_rawat],
                        ['sc.tgl_sep', '=', $tgl],
                        ['sc.no_rm', 'LIKE', $keywords]
                    ]);
                    $query->orWhere([
                        ['sc.jns_pelayanan', '=',$request->jns_rawat],
                        ['sc.tgl_sep', '=', $tgl],
                        ['p.nama_pasien', 'LIKE', $keywords]
                    ]);
                    $query->orWhere([
                        ['sc.jns_pelayanan', '=',$request->jns_rawat],
                        ['sc.tgl_sep', '=', $tgl],
                        ['sc.no_sep', 'LIKE', $keywords]
                    ]);
                }
            })->get();
            // dd(DB::getQueryLog());

        return $data;
    }
}