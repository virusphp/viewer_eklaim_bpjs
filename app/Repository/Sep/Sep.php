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

    public function getPeserta($noKartu,$tglSep)
    {
        $result = $this->conn->getPeserta($noKartu,$tglSep);
        return $result;
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
        $req = json_encode($this->mapSepUpdate($data));
        $result = $this->conn->updateSep($req);
        if ($result) {
            $this->updateBpjs($data);
        }
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

        $updateSepBpjs = DB::table('sep_bpjs')
                        ->where('no_reg', '=', $data['no_reg'])
                        ->update([
                            'no_sjp' => $data['sep']
                        ]);

        return $updateSep;
    }


    public function simpanBpjs($data)
    {
        // dd($data);
        $simpanSep = DB::table('sep_bpjs')->insert([
            'no_reg' => $data['no_reg'],
            'tgl_sjp' => $data['tglSep'],
            'cob' => $data['cob'],
            'catatan' => $data['catatan'],
            'kd_faskes' => $data['ppkRujukan'],
            'nama_faskes' => $data['namaFaskes'],
            'kd_diagnosa' => $data['diagAwal'],
            'nama_diagnosa' => $data['diagnosa'],
            'kd_poli' => $data['tujuan'],
            'nama_poli' => $data['poli'],
            'kd_kelas_rawat' => $data['klsRawat'],
            'nama_kelas_rawat' => $data['namaKelas'],
            'no_rujukan' => $data['noRujukan'],
            'asal_faskes' => $data['asalRujukan'],
            'tgl_rujukan' => $data['tglRujukan'],
            'no_surat' => $data['noSurat'],
            'kd_dpjp' => $data['kodeDPJP'],
            'dokter_dpjp' => $data['dokterDPJP'],
            'katarak' => $data['katarak'],
            'lakalantas' => $data['lakaLantas'],
            'penjamin' => $data['penjamin'],
            'suplesi' => $data['suplesi'],
            'no_sep_suplesi' => $data['noSepSuplesi'],
            'tgl_kejadian' => $data['tglKejadian'],
            'kd_propinsi' => $data['kdPropinsi'],
            'kd_kabupaten' => $data['kdKabupaten'],
            'kd_kecamatan' => $data['kdKecamatan'],
            'keterangan' => $data['keterangan'],
            'user' => $data['user']
        ]);
        
        return $simpanSep;
    }

    public function updateBpjs($data)
    {
        $updateSep = DB::table('sep_bpjs')->where('no_reg', '=', $data['no_reg'])
            ->update([
                'kd_diagnosa' => $data['diagAwal'],
                'nama_diagnosa' => $data['diagnosa'],
                'kd_poli' => $data['tujuan'],
                'nama_poli' => $data['poli'],
                'catatan' => $data['catatan'],
                'no_surat' => $data['noSurat'],
                'kd_dpjp' => $data['kodeDPJP'],
                'dokter_dpjp' => $data['dokterDPJP'],
                'katarak' => $data['katarak'],
                'lakalantas' => $data['lakaLantas'],
                'penjamin' => $data['penjamin'],
                'suplesi' => $data['suplesi'],
                'no_sep_suplesi' => $data['noSepSuplesi'],
                'tgl_kejadian' => $data['tglKejadian'],
                'kd_propinsi' => $data['kdPropinsi'],
                'kd_kabupaten' => $data['kdKabupaten'],
                'kd_kecamatan' => $data['kdKecamatan'],
                'keterangan' => $data['keterangan'],
                'user' => $data['user']
            ]);

        return $updateSep;
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

    public function mapSepUpdate($data)
    {
        $res['noSep'] = $data['noSep'];
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
            'eksekutif' => $data['eksekutif']
        ];
        $res['cob'] = [
            'cob' => $data['cob']
        ];

        $res['katarak'] = [
           'katarak' => $data['katarak'] 
        ];

        $res['skdp'] = [
            'noSurat' => $data['noSurat'],
            'kodeDPJP' => $data['kodeDPJP']
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