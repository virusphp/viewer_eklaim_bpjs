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
        $req = json_encode($this->mapSep($data));
        $result = $this->conn->saveSep($req);

        if ($result) {
            $this->simpanBpjs($data);
        }
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
                            'no_SJP' => $data['sep']
                        ]);

        $updateRujukan = DB::table('Rujukan')
                        ->where('no_reg', '=', $data['no_reg'])
                        ->update([
                            'no_rujukan' => $data['no_rujukan']
                        ]);

        return $updateSep;
    }


    public function simpanBpjs($data)
    {
        dd($data);
        $simpanSep = DB::table('sep_bpjs')->insert([
            'no_reg' => $data['no_reg'],
            'cob' => $data['cob'],
            'kd_faskes' => $data['ppkRujukan'],
            'nama_faskes' => $data['namaFaskes'],
            'kd_diagnosa' => $data['diagAwal'],

        ]);
    }

    public function mapSep($data)
    {
        $res['noKartu'] = $data['noKartu'];
        $res['tglSep'] = $data['tglSep'];
        $res['ppkPelayanan'] = $data['ppkPelayanan'];
        $res['jnsPelayanan'] = $data['jnsPelayanan'];
        $res['klsRawat'] = $data['klsRawat'];
        $res['noMR'] = $data['noMR'];
        $res['rujukan'] = [
            'asalRujukan' => $data['asalRujukan'],
            'tglRujukan' => $data['tglRujukan'],
            'noRujukan' => $data['noRujukan'],
            'ppkRujukan' => $data['ppkRujukan']
        ];
        $res['catatan'] = $data['catatan'];
        $res['diagAwal'] = $data['diagAwal'];
        $res['poli'] = [
            'tujuan' => $data['tujuan'],
            'eksekutif' => $data['eksekutif']
        ];

        $res['cob'] = [
            'cob' => $data['cob']
        ];

        $res['katarak'] = [
           'katarak' => $data['katarak'] 
        ];

        $lokasiLaka = [
            'kdPropinsi' => $data['kdPropinsi'],
            'kdKabupaten' => $data['kdKabupaten'],
            'kdKecamatan' => $data['kdKecamatan']
        ];

         $suplesi = [
            'suplesi' => $data['suplesi'],
            'noSepSuplesi' => $data['noSepSuplesi'],
            'lokasiLaka' => $lokasiLaka
        ];

        $penjamin = [
            'penjamin' => $data['penjamin'],
            'tglKejadian' => $data['tglKejadian'],
            'keterangan' => $data['keterangan'],
            'suplesi' => $suplesi
        ];

        $res['jaminan'] = [
            'lakaLantas' => $data['lakaLantas'],
            'penjamin' => $penjamin
        ]; 
        
        $res['skdp'] = [
            'noSurat' => $data['noSurat'],
            'kodeDPJP' => $data['kodeDPJP']
        ];

        $res['noTelp'] = $data['noTelp'];
        $res['user'] = $data['user'];

        $result = [
           't_sep' => $res 
        ];

        $request = [
            'request' => $result
        ];

        return $request;
    }
}