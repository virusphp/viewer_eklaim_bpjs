<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\Siranap\ServiceSiranap;
use App\Repository\Siranap\Siranap;
ini_set('max_execution_time', 800);

class SiranapMonitoring extends Command
{
    protected $siranap, $serviceSiranap;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siranap:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Tempat Tidur Siranap';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->siranap = new Siranap;
        $this->serviceSiranap = new ServiceSiranap;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = json_decode($this->siranap->getSearch());
        $xmlStr = "<xml>\n";
        foreach($data as $key => $v)
        {
            $xmlStr .= "<data>\n";
            $xmlStr .= "<kode_ruang>".$v->kode_ruang."</kode_ruang>\n";
            $xmlStr .= "<tipe_pasien>".$v->tipe_pasien."</tipe_pasien>\n";
            $xmlStr .= "<total_TT>".$v->total_TT."</total_TT>\n";
            $xmlStr .= "<terpakai_male>".$v->terpakai_male."</terpakai_male>\n";
            $xmlStr .= "<terpakai_female>".$v->terpakai_female."</terpakai_female>\n";
            $xmlStr .= "<kosong_male>".$v->kosong_male."</kosong_male>\n";
            $xmlStr .= "<kosong_female>".$v->kosong_female."</kosong_female>\n";
            $xmlStr .= "<waiting>".$v->waiting."</waiting>\n";
            $xmlStr .= "<tgl_update>".$v->tgl_update."</tgl_update>\n";
            $xmlStr .= "</data>\n";
        }
        $xmlStr .="</xml>\n";
        print json_decode($this->serviceSiranap->updateSiranap($xmlStr))->deskripsi;
        // $curl = curl_init(); 
        // curl_setopt($curl, CURLOPT_URL, config('bpjs.api.siranap'));  
        // curl_setopt($curl, CURLOPT_HTTPHEADER, Array(
        //     "Content-Type:application/xml; charset=ISO-8859-1",
        //     "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15") 
        // ); 
        // curl_setopt($curl, CURLOPT_NOBODY, false);
        // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        // curl_setopt($curl, CURLOPT_POST, 1);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlStr);
        // $str = curl_exec($curl);  
        // curl_close($curl);  
        // print $str;
    }
}
