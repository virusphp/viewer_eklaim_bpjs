<?php

namespace App\Repository\User;
use DB;

class User
{
    protected $conn = "sqlsrv";

    public function getSearch($request)
    {
        $data = DB::table('user_login_sep')->select('kd_pegawai','nama_pegawai','created_at','role')
            ->where(function($query) use ($request) {
                if ($term = $request->get('search')) {
                    $keywords = '%'. $term .'%';
                    $query->orWhere('nama_pegawai', 'like', $keywords);
                    $query->orWhere('kd_pegawai', 'like', $keywords);
                    $query->orWhere('role', 'like', $keywords);
                }
            })        
            ->get();
        return $data;
    }

    public function getPegawai($kode)
    {
        $data = DB::table('pegawai')->select('kd_pegawai','nama_pegawai', 'alamat', 'tgl_lahir', 'tempat_lahir','unit_kerja','foto')
                ->where(function($query) use ($kode) {
                    if ($kode) {
                        $keywords = '%'. $kode . '%';
                        $query->orWhere('nama_pegawai', 'like', $keywords);
                    }
                })
                ->get();
        return $data;
    }

    public function getFoto($req)
    {
        // dd($req->kd);
        $data = DB::table('pegawai')->select('foto')->where('kd_pegawai', '=', $req->kd)->first();
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