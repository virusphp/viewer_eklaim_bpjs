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
        DB::beginTransaction();
        try{
            $req = json_encode($this->mapSep($data));
            $result = $this->conn->saveSep($req);
            if ($result) {
                $res = json_decode($result);
                if ($res->response != null) {
                    $this->simpanBpjs($data);
                    if ($data['jnsPelayanan'] == 2) {
                        $this->simpanRujukan($data);
                    }
                } else {
                    DB::rollback();
                    return $result;
                }
                DB::commit();
            }
            return $result;
        } catch (\Exception $e) {
            DB::rollback();
            return $result;
        }
       
    }

    public function updateSep($data)
    {
        // dd($data);
        DB::beginTransaction();
        try{
            $req = json_encode($this->mapSepUpdate($data));
            // dd($req);
            $result = $this->conn->updateSep($req);
            if ($result) {
                $res = json_decode($result);
                if ($res->response != null) {
                    $this->updateBpjs($data);
                    if ($data['jnsPelayanan'] == 2) {
                        $this->simpanRujukan($data);
                    }
                } else {
                    DB::rollback();
                    return $result;
                }
                DB::commit();
            }
            return $result;
        } catch (\Exception $e) {
            DB::rollback();
            return $result;
        }
    }

    public function simpanRujukan($data)
    {
        $uRujukan = DB::table('Rujukan')
                    ->where('no_reg', '=', $data['no_reg'])
                    ->update([
                        'kd_instansi' => $data['namaInstansi']
                    ]);
        $updateReg = DB::table('Registrasi')
                    ->where('no_reg', '=', $data['no_reg'])
                    ->update([
                        'kd_asal_pasien', '=', $data['asalPasien']
                    ]);

        return $uRujukan;
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
        $simpanSep = DB::table('sep_bpjs')->insert([
            'no_reg' => $data['no_reg'],
            'COB' => $data['cob'],
            'Kd_Faskes' => $data['ppkRujukan'],
            'Nama_Faskes' => $data['namaFaskes'],
            'Kd_Diagnosa' => $data['diagAwal'],
            'Nama_Diagnosa' => $data['diagnosa'],
            'Kd_poli' => $data['tujuan'],
            'Nama_Poli' => $data['poli'],
            'Kd_Kelas_Rawat' => $data['klsRawat'],
            'Nama_kelas_rawat' => $data['namaKelas'],
            'No_Rujukan' => $data['noRujukan'],
            'Asal_Faskes' => $data['asalRujukan'],
            'Tgl_Rujukan' => $data['tglRujukan'],
            'Lakalantas' => $data['lakaLantas'],
            'no_surat_kontrol' => $data['noSurat'],
            'kd_dpjp' => $data['kodeDPJP']
        ]);
        
        // dd($data);
        return $simpanSep;
    }

    public function updateBpjs($data)
    {
        $updateSep = DB::table('sep_bpjs')->where('no_reg', '=', $data['no_reg'])
            ->update([
                'no_reg' => $data['no_reg'],
                'COB' => $data['cob'],
                'Kd_Faskes' => $data['ppkRujukan'],
                'Nama_Faskes' => $data['namaFaskes'],
                'Kd_Diagnosa' => $data['diagAwal'],
                'Nama_Diagnosa' => $data['diagnosa'],
                'Kd_poli' => $data['tujuan'],
                'Nama_Poli' => $data['poli'],
                'Kd_Kelas_Rawat' => $data['klsRawat'],
                'Nama_kelas_rawat' => $data['namaKelas'],
                'No_Rujukan' => $data['noRujukan'],
                'Asal_Faskes' => $data['asalRujukan'],
                'Tgl_Rujukan' => $data['tglRujukan'],
                'Lakalantas' => $data['lakaLantas'],
                'no_surat_kontrol' => $data['noSuratLama'],
                'kd_dpjp' => $data['kodeDPJP']
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
            'noSurat' => $data['noSuratLama'],
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