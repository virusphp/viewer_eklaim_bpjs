<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\User\User;
use App\Charts\EklaimChart;
use App\Repository\Api\ClaimSep;

class HomeController extends Controller
{
    protected $user, $claimSep;

    public function __construct()
    {
        $this->user = New User();
        $this->middleware('auth');
        $this->claimSep = new ClaimSep();
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->claimSep->getChartKlaim($request);
        $type    = $request->has('type') ? $request->type : 'bar';

        $chart = $this->chart($data, "Data Chart Claim", $type);
        // dd($pegawai_ultah);
        return view('home', compact('cart'));
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
                file_put_contents(public_path("images/pegawai").DIRECTORY_SEPARATOR.($filename = $val->kd_pegawai.".jpg"), $val->foto);
                $dataPegawai[$key] = $val;
                // dd($dataPegawai);
                unset($val->foto);
            }
        } else {
            $dataPegawai = [];
        }
    
        return $dataPegawai;
    }

    private function chart($data, $judul, $type)
    {
        $api = ('/chart/pemohon/tahun');
        $chart = new EklaimChart;
        $bulan = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec',
        ];

        $chart->barwidth(0.0);
        $chart->displaylegend(false);
        $chart->labels($bulan);
        $chart->dataset($judul, $type, $data)
              ->color("rgb(255, 99, 132)")
              ->backgroundcolor("rgb(255,99,132)")
              ->fill(false)
              ->linetension(0.1)
              ->dashed([5]);
        return $chart->load($api);
    }


}
