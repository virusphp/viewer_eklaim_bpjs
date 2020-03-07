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
        $chart = $this->chart();
        return view('home',compact('chart'));
    }

    public function chartAjax(Request $request)
    {
        $data = $this->claimSep->getChartKlaim($request);
        // dd($data);
        $chart = new EklaimChart;
        $bulan = [
            'Jan' => 0,
            'Feb' => 0,
            'Mar' => 0,
            'Apr' => 0,
            'May' => 0,
            'Jun' => 0,
            'Jul' => 0,
            'Aug' => 0,
            'Sep' => 0,
            'Oct' => 0,
            'Nov' => 0,
            'Dec' => 0,
        ];

        if ($data) {
            foreach ($data as $key => $val) {
                $bulan[$key] = $val;
            }
        }
        foreach ($bulan as $val) {
            $values[] =  $val;
        }

        $chart->barwidth(0.0);
        $chart->displaylegend(false);
        $chart->labels($bulan);
        $chart->dataset("Data Chart", 'line', $values)
              ->color("rgb(255, 99, 132)")
              ->backgroundcolor("rgb(255,99,132)")
              ->fill(false)
              ->linetension(0.1)
              ->dashed([5]);

        return $chart->api();
    }

    public function chart()
    {
        $api = Route('chart.eklaim');
        $chart = new EklaimChart;
        $chart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])->load($api);
          return $chart;
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
}
