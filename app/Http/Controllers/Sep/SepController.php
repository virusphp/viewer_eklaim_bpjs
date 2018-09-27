<?php

namespace App\Http\Controllers\sep;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\Sep\Registrasi;
// use App\Service\Bpjs\Sep;
use App\Repository\Sep\Sep;
use App\Http\Requests\SepRequest;
use DB;
Use DateTime;

class SepController extends Controller
{
    protected $conn; 

    public function __construct()
    {
        $this->conn = new Sep();
    }
    public function index()
    {
        return view('simrs.sep.index');
    }

    public function search(Request $request, Registrasi $reg)
    {
        // dd($request->all());
        if ($request->ajax()) {
            $no = 1;
            $data = $reg->getSearch($request);
            foreach($data as $q) {
                $query[] = [
                    'no' => $no++,
                    'no_reg' => $q->no_reg,
                    'no_rm' => $q->no_rm,
                    'tgl_reg' => $q->tgl_reg,
                    'jns_rawat' => $q->jns_rawat,
                    'no_sjp' => $q->no_sjp,
                    'aksi' => '
                            <button type="button" value="'.$q->no_reg.'" class="btn btn-sm btn-success" id="edit-item" data-item="'.$q->no_reg.'">Buat</button>
                            <button type="button" value="'.$q->no_reg.'" class="btn btn-sm btn-warning" id="edit-sep" data-sep="'.$q->no_reg.'">Edit</button>
                            '
                ];
            }
            $result = isset($query) ? ['data' => $query] : ['data' => 0];
            // dd($result);
            return json_encode($result);
        } 
    }

    public function buatSep(Request $request)
    { 
        if ($request->ajax()) {
             $noKartu = DB::table('registrasi as r')->select('r.tgl_reg','r.no_sjp','pp.no_kartu','rjk.no_rujukan')
            ->join('penjamin_pasien as pp', function($join){
                $join->on('r.no_rm', '=','pp.no_rm')
                    ->on('r.kd_penjamin','=','pp.kd_penjamin');
            })
            ->join('rujukan as rjk', function($join) {
                $join->on('r.no_reg','=','rjk.no_reg')
                    ->on('r.no_rm','=','rjk.no_rm');
            })
            ->where('r.no_reg','=',$request->no_reg)
            ->first();
            // dd($noKartu);
            $datetime = new DateTime($noKartu->tgl_reg);
            $noKartu->tgl_reg = $datetime->format('Y-m-d');
            $jenis_rawat = noReg($request->no_reg);
            if ($jenis_rawat == '02') {

                $query = DB::table('rawat_inap as ri')->select('ri.no_reg','ri.no_rm','p.alamat','p.nama_pasien','p.no_telp','p.nik','p.tgl_lahir','pg.nama_pegawai')
                    ->join('pasien as p', function($join) {
                        $join->on('ri.no_rm','=','p.no_rm');
                    })
                    ->join('pegawai as pg', function($join) {
                        $join->on('ri.kd_dokter','=','pg.kd_pegawai');
                    })
                    ->join('tempat_tidur as tt',function($join){
                        $join->on('ri.kd_tempat_tidur','=','tt.kd_tempat_tidur')
                            ->join('kamar as k', function($join) {
                                $join->on('tt.kd_kamar','=','k.kd_kamar')
                                    ->join('sub_unit as su',function($join) {
                                        $join->on('k.kd_sub_unit','=','su.kd_sub_unit');
                                    });
                            });
                    })
                    ->where('ri.no_reg','=',$request->no_reg)
                    ->first();
                // dd($query);
                $query->jnsPelayanan = '1';
                $query->noKartu = $noKartu->no_kartu;
                $query->tglSep = $noKartu->tgl_reg;
                $query->noRujukan = ($noKartu->no_rujukan == '-' ? '' : $noKartu->no_rujukan);
            } else if ($jenis_rawat == '01') {
            
                $query = DB::table('rawat_jalan as rj')->select('rj.no_reg','rj.no_rm','p.alamat','p.nama_pasien','p.no_telp','p.nik','p.tgl_lahir')
                    ->join('pasien as p', function($join) {
                        $join->on('rj.no_rm','=','p.no_rm');
                    })
                    ->join('pegawai as pg', function($join) {
                            $join->on('rj.kd_dokter','=','pg.kd_pegawai');
                    })
                    ->where('rj.no_reg','=',$request->no_reg)
                    ->first();
                // dd($query);
                $query->jnsPelayanan = '2';
                $query->noKartu = $noKartu->no_kartu;
                $query->tglSep = $noKartu->tgl_reg;
                $query->noRujukan = ($noKartu->no_rujukan == '-' ? '' : $noKartu->no_rujukan);
            }
            return response()->json($query);
        }
    }

    public function editSep(Request $request)
    {
        if ($request->ajax()) {
            $noKartu = DB::table('registrasi as r')->select('r.tgl_reg','r.no_sjp','pp.no_kartu','rjk.no_rujukan')
            ->join('penjamin_pasien as pp', function($join){
                $join->on('r.no_rm', '=','pp.no_rm')
                    ->on('r.kd_penjamin','=','pp.kd_penjamin');
            })
            ->join('rujukan as rjk', function($join) {
                $join->on('r.no_reg','=','rjk.no_reg')
                    ->on('r.no_rm','=','rjk.no_rm');
            })
            ->where('r.no_reg','=',$request->no_reg)
            ->first();
            // dd($noKartu);

            $datetime = new DateTime($noKartu->tgl_reg);
            $noKartu->tgl_reg = $datetime->format('Y-m-d');
            $jenis_rawat = noReg($request->no_reg);
            if ($jenis_rawat == '02') {

                $query = DB::table('rawat_inap as ri')->select('ri.no_reg','ri.no_rm','p.alamat','p.nama_pasien','p.no_telp','p.nik','p.tgl_lahir','pg.nama_pegawai')
                    ->join('pasien as p', function($join) {
                        $join->on('ri.no_rm','=','p.no_rm');
                    })
                    ->join('pegawai as pg', function($join) {
                        $join->on('ri.kd_dokter','=','pg.kd_pegawai');
                    })
                    ->join('tempat_tidur as tt',function($join){
                        $join->on('ri.kd_tempat_tidur','=','tt.kd_tempat_tidur')
                            ->join('kamar as k', function($join) {
                                $join->on('tt.kd_kamar','=','k.kd_kamar')
                                    ->join('sub_unit as su',function($join) {
                                        $join->on('k.kd_sub_unit','=','su.kd_sub_unit');
                                    });
                            });
                    })
                    ->where('ri.no_reg','=',$request->no_reg)
                    ->first();
                // dd($query);
                $query->noSep = $noKartu->no_sjp;
                $query->jnsPelayanan = '1';
                $query->noKartu = $noKartu->no_kartu;
                $query->tglSep = $noKartu->tgl_reg;
                $query->noRujukan = ($noKartu->no_rujukan == '-' ? '' : $noKartu->no_rujukan);
            } else if ($jenis_rawat == '01') {
            
                $query = DB::table('rawat_jalan as rj')->select('rj.no_reg','rj.no_rm','p.alamat','p.nama_pasien','p.no_telp','p.nik','p.tgl_lahir')
                    ->join('pasien as p', function($join) {
                        $join->on('rj.no_rm','=','p.no_rm');
                    })
                    ->join('pegawai as pg', function($join) {
                            $join->on('rj.kd_dokter','=','pg.kd_pegawai');
                    })
                    ->where('rj.no_reg','=',$request->no_reg)
                    ->first();
                $query->noSep = $noKartu->no_sjp;
                $query->jnsPelayanan = '2';
                $query->noKartu = $noKartu->no_kartu;
                $query->tglSep = $noKartu->tgl_reg;
                $query->noRujukan = ($noKartu->no_rujukan == '-' ? '' : $noKartu->no_rujukan);
                // dd($query);
            }
            return response()->json($query);
        }
    }

    public function sepInsert(SepRequest $req)
    {
        if ($req->ajax()) {
            $data = $req->all();
            // dd($data);
            if ($data['penjamin'] != 0) {
                $data['penjamin'] = implode(",",$data['penjamin']);
            }
            // $data['tglSep'] = date('Y-m-d');
            // $datetime = new DateTime('tomorrow');
            // $data['tglSep'] = $datetime->format('Y-m-d');
            $data['ppkPelayanan'] = '1105R001';
            $data['tglKejadian'] = date('Y-m-d', strtotime($data['tglKejadian']));
            $data['klsRawat'] = '3';
            $data['user'] = 'udin admin';
            // dd($data);
            $res = json_encode($this->mapSep($data));
            $result = $this->conn->saveSep($res);
            return $result;
        }
    }

    public function sepUpdate(SepRequest $req)
    {
        if ($req->ajax()) {
            $data = $req->all();
            if ($data['penjamin'] != 0) {
                $data['penjamin'] = implode(",",$data['penjamin']);
            }
            $data['ppkPelayanan'] = '1105R001';
            $data['tglKejadian'] = date('Y-m-d', strtotime($data['tglKejadian']));
            $data['klsRawat'] = '3';
            $data['user'] = 'udin admin';
            // dd($data);
            $res = json_encode($this->mapSepUpdate($data));
            $result = $this->conn->updateSep($res);
            return $result;
        }
    }

    public function simpanSep(Request $req)
    {
        $data = $req->all();
        $simpanSep = $this->conn->simpanSep($data);
        return $simpanSep;
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