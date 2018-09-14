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
        return $result;
    }


    public function simpanSep($data)
    {
        // dd($data);
        $updateSep = DB::table('Registrasi')
                        ->where('no_reg', '=', $data['no_reg'])
                        ->update([
                            'no_SJP' => $data['no_sep']
                        ]);
        return $updateSep;
    }
}