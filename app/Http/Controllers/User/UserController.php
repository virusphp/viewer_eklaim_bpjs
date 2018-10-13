<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use DateTime;
use App\Repository\User\User;

class UserController extends Controller
{
    public function index()
    {
        return view('simrs.user.index');
    }

    public function search(Request $request, User $user)
    {
        if ($request->ajax()) {
            $no = 1;
            $data = $user->getSearch($request);
            foreach($data as $q) {
                $tgl = new DateTime($q->tgl_create);
                $query[] = [
                    'no' => $no++,
                    'kd_pegawai' => $q->kd_pegawai,
                    'nama_pegawai' => $q->nama_pegawai,
                    'tgl_create' => $tgl->format('Y-m-d'),
                    'role' => $tgl->role,
                    'aksi' => '<button>HAPUS</button>'
                ];
            }
            $result = isset($query) ? ['data' => $query] : ['data' => 0];
            return json_encode($result);
        }
    }
}
