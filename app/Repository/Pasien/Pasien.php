<?php

namespace App\Repository\Pasien;
use GuzzleHttp\Client;
use DB;
use GuzzleHttp\Psr7;
use Guzzle\Http\Message\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
class Pasien
{
    protected $conn = "sqlsrv";

    public function getPegawai($kode)
    {
        $data = DB::table('pasien')->select('no_rm','nama_pasien', 'alamat', 'tgl_lahir', 'tempat_lahir','unit_kerja','foto')
                ->where(function($query) use ($kode) {
                    if ($kode) {
                        $keywords = '%'. $kode . '%';
                        $query->orWhere('nama_pegawai', 'like', $keywords);
                    }
                })
                ->get();
        return $data;
    }

    public function getKartu($req)
    {
        $data = DB::table('penjamin_pasien as pp')
                  ->select('pp.no_rm','pp.no_kartu','pp.kd_penjamin', 'p.nama_penjamin')
                  ->join('penjamin as p', 'pp.kd_penjamin', '=', 'p.kd_penjamin')
                  ->where('no_rm', $req->noRm)->first();
        return $data;
    }

    public function simpanUser($data)
    {
        $result = DB::table('user_login_sep')->insert([
            'kd_pegawai' => $data['username'],
            'nama_pegawai' => $data['nama_pegawai'],
            'password' => bcrypt($data['password']),
            'role' => $data['role']
        ]);
        
        if ($result) {
            $res = $this->getPesan('simpan');
        } else {
            $res = $this->getPesan('error');
        }
        return $res;
    }

    public function deleteUser($data)
    {
        $result = DB::table('user_login_sep')
                    ->where('kd_pegawai', '=', $data['kode'])
                    ->delete();
        if ($result) {
            $res = $this->getPesan('delete');
        } else {
            $res = $this->getPesan('error');
        }
        return $res;
        return $result;
    }

    protected function getPesan($nilai)
    {
        switch ($nilai) {
            case 'simpan' :
                $notif = [
                    'status' => 'success',
                    'message' => 'User akun berhasil di buat'
                ];
                break;
            case 'delete' :
                $notif = [
                    'status' => 'success',
                    'message' => 'User akun berhasil di hapus!!'
                ];
                break;
            case 'error' :
                $notif = [
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan silahkan ulangi!'
                ];
                break;
            default : 
                $notif = false;
                break;
        }
        return $notif;
    }

}