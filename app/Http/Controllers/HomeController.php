<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\User\User;

class HomeController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = New User();
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawai_ultah = $this->pegawai();
        // dd($pegawai_ultah);
        return view('home', compact('pegawai_ultah'));
    }

    public function pegawai()
    {
        $bulan = date('m');
        $hari = date('d');
        $pegawai = $this->user->getUltahPegawai($hari, $bulan);  
      
        if ($pegawai->count() != 0) {
            $dataPegawai = [];
            foreach ($pegawai as $key => $val) {
                // dd($val);
                file_put_contents(public_path("images/pegawai")."\\".($filename = $val->kd_pegawai.".jpg"), $val->foto);
                $dataPegawai[$key] = $val;
                // dd($dataPegawai);
                unset($val->foto);
            }
        } else {
            $dataPegawai = [];
        }
    
        return $dataPegawai;
    }
}
