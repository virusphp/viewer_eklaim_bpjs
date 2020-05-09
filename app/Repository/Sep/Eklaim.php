<?php

namespace App\Repository\Sep;
use DB;
use Auth;

Class Eklaim
{
    public function getView($request)
    {
        // $data  = DB::table('penjamin_pasien')->where('no_rm', "427466")->get();
        // DB::enableQueryLog();
        $data = DB::table('sep_claim as sc')
            ->select('sc.no_reg','sc.no_sep','sc.no_rm','sc.tgl_sep', 'sc.tgl_pulang', 'sc.file_claim', 'p.nama_pasien', 'pp.no_kartu', 'sc.periksa', 'sc.user_verified', 'sc.user_created')
            ->join('pasien as p','sc.no_rm','=','p.no_rm')
            ->join('penjamin_pasien as pp', function($join) {
                $join->on('sc.no_rm', '=', 'pp.no_rm');
                    // ->where('pp.kd_penjamin', '=', '23')
                    // ->whereRaw('LENGTH(kd_penjamin) = 14');
                    // ->first();
            })
            ->where(function ($query) use ($request) {
                $tgl = date('Y-m-d', strtotime($request->tgl_plg));
                if ($request->search == null) {
                    $query->orWhere([
                        ['sc.jns_pelayanan', '=', $request->jns_rawat],
                        ['sc.tgl_pulang', '=', $tgl],
                        ['pp.kd_penjamin', '=', '23']
                    ]);
                    $query->orWhere([
                        ['sc.jns_pelayanan', '=', $request->jns_rawat],
                        ['sc.tgl_pulang', '=', $tgl],
                        ['pp.kd_penjamin', '=', '24']
                    ]);

                } else {
                    $term = $request->get('search');
                    $keywords = '%'. $term .'%';
                    // dd($keywords);
                    $query->orWhere([
                        ['sc.jns_pelayanan', '=',$request->jns_rawat],
                        ['sc.tgl_pulang', '=', $tgl],
                        ['sc.no_rm', 'LIKE', $keywords],
                        ['pp.kd_penjamin', '=', '23']
                    ]);
                    $query->orWhere([
                        ['sc.jns_pelayanan', '=',$request->jns_rawat],
                        ['sc.tgl_pulang', '=', $tgl],
                        ['p.nama_pasien', 'LIKE', $keywords],
                        ['pp.kd_penjamin', '=', '23']
                    ]);
                    $query->orWhere([
                        ['sc.jns_pelayanan', '=',$request->jns_rawat],
                        ['sc.tgl_pulang', '=', $tgl],
                        ['sc.no_sep', 'LIKE', $keywords],
                        ['pp.kd_penjamin', '=', '23']
                    ]);

                    $query->orWhere([
                        ['sc.jns_pelayanan', '=',$request->jns_rawat],
                        ['sc.tgl_pulang', '=', $tgl],
                        ['sc.no_rm', 'LIKE', $keywords],
                        ['pp.kd_penjamin', '=', '24']
                    ]);
                    $query->orWhere([
                        ['sc.jns_pelayanan', '=',$request->jns_rawat],
                        ['sc.tgl_pulang', '=', $tgl],
                        ['p.nama_pasien', 'LIKE', $keywords],
                        ['pp.kd_penjamin', '=', '24']
                    ]);
                    $query->orWhere([
                        ['sc.jns_pelayanan', '=',$request->jns_rawat],
                        ['sc.tgl_pulang', '=', $tgl],
                        ['sc.no_sep', 'LIKE', $keywords],
                        ['pp.kd_penjamin', '=', '24']
                    ]);
                }
            })
            ->distinct()
            ->get();
            // dd(DB::getQueryLog());

        return $data;
    }

    public function cari($no_reg)
    {
        $result = DB::table('sep_claim')->where('no_reg', $no_reg)->first();
        return $result;
    }

    public function update($data)
    {
        $now = date('Y-m-d');
        if ($data->periksa == 1) {
            $user_verified = Auth::user()->nama_pegawai;
        } else {
            $user_verified = Auth::user()->nama_pegawai;;
        }

        $update = DB::table('sep_claim')->where('no_reg', $data->no_reg)
                    ->update([
                        'periksa' => $data->periksa,
                        'user_verified' =>  $user_verified,
                        'tgl_verified' => $now
                    ]);

        return $this->Message($update, "update");
    }

    public function updateAll($periksa, $noReg)
    {
        $now = date('Y-m-d');
        if ($periksa == 1) {
            $user_verified = Auth::user()->nama_pegawai;
        } else {
            $user_verified = Auth::user()->nama_pegawai;;
        }

        $update = DB::table('sep_claim')->where('no_reg', $noReg)
                    ->update([
                        'periksa' => $periksa,
                        'user_verified' =>  $user_verified,
                        'tgl_verified' => $now
                    ]);

        return $this->Message($update, "update");
    }

    public function Message($data, $pesan)
    {
        if ($data) {
            $message = ['kode' => 200, 'pesan' => 'Data berhasil di ' . $pesan . '!'];
        } else {
            $message = ['kode' => 500, 'pesan' => 'Ada kesalahan sistem'];
        }

        return $message;
    }
}