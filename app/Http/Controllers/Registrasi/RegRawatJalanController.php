<?php

namespace App\Http\Controllers\Registrasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\Registrasi\Registrasi;
use App\Service\Pasien\Pasien;
use App\Service\Registrasi\Registrasi as Daftar;
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
                    'nama_pasien' => $q->nama_pasien,
                    'tgl_reg' => $tgl->format('Y-m-d'),
                    'jns_rawat' => jenisRawat($q->jns_rawat),
                    'no_sjp' => $q->no_sjp,
                    'kd_cara_bayar' => caraBayar($q->kd_cara_bayar)
                ];
            }
            $result = isset($query) ? ['data' => $query] : ['data' => 0];
            return json_encode($result);
        }
    }

    public function searchPasien(Request $req, Pasien $ps)
    {
        if ($req->ajax()) {
            $pasien = $ps->getPasien($req);
            // dd($pasien);
            if ($pasien) {
                $res = json_decode($pasien)[0];
            }
            return response()->json($res);
        }
    }

    public function getKartu(Request $req, Pasien $ps)
    {
        if ($req->ajax()) {
            $pasien = $ps->getKartu($req);
            return $pasien;
        }
    }

    public function sendpasien(Request $req, Daftar $daftar)
    {
        if ($req->ajax()) {
            // dd($tgl_reg->format('Y-m-d'),$tgl_reg->format('h:i:s'));
            $data = $this->remap($req);
            $result = $daftar->sendregister($data);
            return $result;
        }
    }

    public function remap($data)
    {
        $date = new DateTime();
        $tgl_reg = $date->format('Y-m-d');
        $waktu = $date->format('h:i:s');
        return [
            '_token' => $data->_token,
            'no_RM' => $data->no_rm,
            'tgl_reg' => $tgl_reg,
            'waktu' => $waktu,
            'kd_sub_unit' => $data->kd_sub_unit,
            'kd_cara_bayar' => $data->kd_cara_bayar,
            'kd_asal_pasien' => 1,
            'kd_tarif' => $data->kd_tarif,
            'kd_pegawai' => $data->kd_pegawai,
            'Rek_P' => $data->Rek_P,
            'hak_kelas' => $data->hak_kelas,
            'no_telp' => $data->no_telp,
            'user_id' => '000003'
        ];
    }
}