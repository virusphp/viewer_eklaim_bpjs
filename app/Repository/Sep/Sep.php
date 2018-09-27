<?php
namespace App\Repository\Sep;

use App\Service\Bpjs\Sep as ServiceSEP;
use DB;

class Sep
{
    protected $conn;

    public function __construct()
    {
        $this->conn = new ServiceSEP();
    }

    public function saveSep($data)
    {
        $result = $this->conn->saveSep($data);
        if($result)
        return $result;
    }

    public function updateSep($data)
    {
        $result = $this->conn->updateSep($data);
        return $result;
    }

    public function simpanSep($data)
    {
        $updateSep = DB::table('Registrasi')
                        ->where('no_reg', '=', $data['no_reg'])
                        ->update([
                            'no_SJP' => $data['sep']['noSep']
                        ]);

        $updateRujukan = DB::table('Rujukan')
                        ->where('no_reg', '=', $data['no_reg'])
                        ->update([
                            'no_rujukan' => $data['no_rujukan']
                        ]);
        dd($data);
        // $simpanSep = $this->simpanBpjs($data);

        return $updateSep;
    }


    public function simpanBpjs($data)
    {
        $simpanSep = DB::table('sep_bpjs')->insert([
            'no_reg' => $data['no_reg'],
            'no_sjp' => $data['sep']['noSep'],
            'cob' => $data['sep']['cob'],
            'kd_faskes' => $data['']
        ]);
    }
}