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
                $tgl = new DateTime($q->created_at);
                if ($q->role == 'developer' || $q->role == 'superadmin') {
                    $button = '<button type="button" class="btn btn-sm btn-danger" disabled>Hapus</button>';
                } else {
                    $button = '<button type="button" class="btn btn-sm btn-danger" id="delete-user" data-user="'.$q->kd_pegawai.'" onclick="return deleteUser()">Hapus</button>';
                }
               
                $query[] = [
                    'no' => $no++,
                    'kd_pegawai' => $q->kd_pegawai,
                    'nama_pegawai' => $q->nama_pegawai,
                    'created_at' => $tgl->format('Y-m-d'),
                    'role' => $q->role,
                    'aksi' => $button
                ];
            }
            $result = isset($query) ? ['data' => $query] : ['data' => 0];
            return json_encode($result);
        }
    }

    public function pegawai(Request $req, User $user)
    {
        if ($req->ajax()) {
            $request = $req->get('term');
            $pegawai = $user->getPegawai($request);
            // dd($pegawai);
            file_put_contents(public_path("images/user")."\\".($filename = $pegawai[0]->kd_pegawai.".jpg"), $pegawai[0]->foto);
            // dd($filename);
            // $pegawai[0]->foto = chunk_split(base64_encode($pegawai[0]->foto));
            $pegawai[0]->foto = $filename;
            $pegawai[0]->tgl_lahir = tanggal($pegawai[0]->tgl_lahir);
            header("Content-type: image/jpeg");
            // dd($pegawai);
            return $pegawai;
        }
    }

    public function getFoto(Request $req, User $user)
    {
        if ($req->ajax()) {
            $pegawai = $user->getFoto($req);
            $pegawai->foto = chunk_split(base64_encode($pegawai->foto));
            header("Content-type: image/jpeg");
            return response()->json($pegawai);
        }
    }

    public function simpanUser(Request $req, User $user)
    {
        // dd($req->all());
        if ($req->ajax()) {
            $data = $req->all();
            $result = $user->simpanUser($data);
            return $result;
        }
    }

    public function deleteUser(Request $req, User $user)
    {
        // dd($req->all());
        if ($req->ajax()) {
            $data = $req->all();
            $result = $user->deleteUser($data);
            return $result;
        }
    }

    public function getEdit($id, User $user)
    {
        $user = $user->getUser($id);
        return view('simrs.user.edit', compact('user'));
    }

    public function getUpdate(Request $request, $id, User $user)
    {
        $this->validate($request, [
            'password' => 'required|min:3|confirmed:password_confirmation'
        ],
        [
            'password.required' => 'Password harus di isi ya gaes!!',
            'password.min' => 'Password harus lebih dari 3 digit',
            'password.confirmed' => 'Password confirmasi harus di isi'
        ]);

       $user = $user->getUpdate($request, $id);
       if ($user) {
           $notif = $this->getPesan('update');
       }
       return redirect()->route('home')->with($notif);
    }

    public function getPesan($nilai)
    {
        switch ($nilai) {
            case 'create' :
                $notif = [
                    'alert-type' => 'success',
                    'message' => 'User berhasil di buat!'
                ];
                break;
            case 'update' :
                $notif = [
                    'alert-type' => 'success',
                    'message' => 'Berhasil Ganti Password!'
                ];
                break;
            case 'delete' :
                $notif = [
                    'alert-type' => 'success',
                    'message' => 'User berhasil di Hapus!'
                ];
                break;
            case 'error' :
                $notif = [
                    'alert-type' => 'warning',
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
