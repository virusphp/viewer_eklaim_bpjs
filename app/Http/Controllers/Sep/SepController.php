<?php

namespace App\Http\Controllers\sep;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\Sep\Registrasi;
use App\Repository\Sep\Sep;
use App\Service\Bpjs\Sep as cetak;
use App\Http\Requests\SepRequest;
use DB;
Use DateTime;
use PDF;

class SepController extends Controller
{
    protected $conn; 

    public function __construct()
    {
        $this->conn = new Sep();
        $this->cetak = new cetak();
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
                $tgl = new DateTime($q->tgl_reg);
                // dd(empty($q->no_sjp), $q->no_sjp == "");
                if ($q->no_sjp <= 15) {
                    $button = '<button type="button" value="'.$q->no_reg.'" class="btn btn-sm btn-success" id="edit-item" data-item="'.$q->no_reg.'">Buat</button>
                               <button type="button" class="btn btn-sm btn-warning" id="edit-sep" disabled>Edit</button>
                               <button type="button" class="btn btn-sm btn-primary" id="print-sep" disabled>Print</button>';
                } else {
                    $button = '<button type="button" class="btn btn-sm btn-success" id="edit-item" disabled>Buat</button>
                               <button type="button" value="'.$q->no_reg.'" class="btn btn-sm btn-warning" id="edit-sep" data-sep="'.$q->no_sjp.'" >Edit</button>
                               <a target="_blank" class="btn btn-sm btn-primary" data-print="'.$q->no_reg.'" id="print-sep">Print</a>';
                }
                $query[] = [
                    'no' => $no++,
                    'no_reg' => $q->no_reg,
                    'no_rm' => $q->no_rm,
                    'nama_pasien' => $q->nama_pasien,
                    'tgl_reg' => $tgl->format('Y-m-d'),
                    'jns_rawat' => jenisRawat($q->jns_rawat),
                    'kd_cara_bayar' => carabayar($q->kd_cara_bayar),
                    'no_sjp' => $q->no_sjp,
                    'aksi' => $button
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
            $noKartu = DB::table('registrasi as r')->select('r.tgl_reg','r.no_sjp','pp.no_kartu')
            ->join('penjamin_pasien as pp', function($join){
                $join->on('r.no_rm', '=','pp.no_rm')
                    ->on('r.kd_penjamin','=','pp.kd_penjamin');
            })
            ->where('r.no_reg','=',$request->no_reg)
            ->first();
            // dd($noKartu);

            $datetime = new DateTime($noKartu->tgl_reg);
            $noKartu->tgl_reg = $datetime->format('Y-m-d');
            $jenis_rawat = noReg($request->no_reg);
            if ($jenis_rawat == '02') {

                $query = DB::table('rawat_inap as ri')->select('ri.no_reg','ri.no_rm','p.alamat','p.nama_pasien','p.no_telp','p.nik','p.tgl_lahir','pg.nama_pegawai','rjk.no_rujukan as noRujukan')
                    ->join('pasien as p', function($join) {
                        $join->on('ri.no_rm','=','p.no_rm');
                    })
                    ->join('pegawai as pg', function($join) {
                        $join->on('ri.kd_dokter','=','pg.kd_pegawai');
                    })
                    ->join('rujukan as rjk', function($join) {
                        $join->on('ri.no_reg', '=', 'rjk.no_reg')
                            ->on('ri.no_rm', '=', 'rjk.no_rm');
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
                // $query->noRujukan = ($query->no_rujukan == '-' ? '' : $query->no_rujukan);
            } else if ($jenis_rawat == '01') {
            
                $query = DB::table('rawat_jalan as rj')->select('rj.no_reg','rj.no_rm','p.alamat','p.nama_pasien','p.no_telp','p.nik','p.tgl_lahir','rjk.no_rujukan as noRujukan')
                    ->join('pasien as p', function($join) {
                        $join->on('rj.no_rm','=','p.no_rm');
                    })
                    ->join('rujukan as rjk', function($join) {
                        $join->on('rj.no_reg', '=', 'rjk.no_reg')
                            ->on('rj.no_rm', '=', 'rjk.no_rm');
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
                // $query->noRujukan = ($query->no_rujukan == '-' ? '' : $query->no_rujukan);
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
            $result = $this->conn->saveSep($data);
            return $result;
        }
    }

    public function sepEdit(Request $req) 
    {
        // dd($req->noReg);
        $data = DB::table('sep_bpjs')->where([['no_reg', '=', $req->noReg], ['no_sjp', '=', $req->noSep]])->first();
        return response()->json($data);
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
            $result = $this->conn->updateSep($data);
            return $result;
        }
    }

    public function simpanSep(Request $req)
    {
        $data = $req->all();
        $simpanSep = $this->conn->simpanSep($data);
        return $simpanSep;
    }

    public function printSep($noReg)
    {
        $data = $this->getDataRegistrasi($noReg);
        // dd($data);
        $data->alamat = $data->alamat.' Kel.'.$data->nama_kelurahan.' Kec.'.$data->nama_kecamatan.' Kab.'.$data->nama_kabupaten.' Prov.'.$data->nama_propinsi;
        
        if (noReg($data->no_reg) == "02") {
            $data->nama_poli = "-";
            $data->antrian =  "-";
        } else {
            $poli =  DB::table('rawat_jalan as rj')->select('su.nama_sub_unit as nama_klinik','rj.kd_poliklinik')
                            ->join('sub_unit as su', function($join) {
                                $join->on('rj.kd_poliklinik', '=', 'su.kd_sub_unit');  
                            })
                            ->where('no_reg', '=', $data->no_reg)
                            ->first();
            $data->nama_poli = $poli->nama_klinik;
            $data->kd_poliklinik = $poli->kd_poliklinik;
            $antrian = $this->noAntrianPoli($data);
            $data->antrian = isset($antrian) != 0 ? $antrian[0]->noantrian : "-";
        }
        // dd($data);
        // dd($antrian)
        $req = $this->cetak->cariSep($data->no_sjp);
        // dd($req);
        unset($data->nama_kecamatan,$data->nama_kelurahan,$data->nama_kabupaten, $antrian, $data->nama_propinsi,$data->tgl_reg, $data->kd_poliklinik,$data->no_sjp);
        $dataSep = json_decode($req);
        $dataSep = $dataSep->response;
        $reqPeserta = $this->cetak->getPeserta($dataSep->peserta->noKartu, $dataSep->tglSep);
        $peserta = json_decode($reqPeserta);
        $peserta = $peserta->response->peserta->informasi;
        // dd($peserta);
        $dataSep->noReg = $data->no_reg;
        $dataSep->noMr = $data->no_rm;
        $dataSep->alamat = $data->alamat;
        $dataSep->kdDiagnosa = $data->kd_diagnosa;
        $dataSep->namaKlinik = $data->nama_poli;
        $dataSep->antrian = $data->antrian;
        $dataSep->asalFaskes = $data->nama_faskes;
        // $genPdf = PDF::loadView('pdf.invoiceSep', array('data' => $dataSep));
        // return $genPdf->stream('No SEP'.$dataSep->noSep.'.pdf');
        return view('pdf.invoiceSep', compact('dataSep', 'peserta'));
    }
    
    public function noAntrianPoli($data)
    {
        if (!empty($data->kd_poliklinik)) {
              $result = DB::select("
            SELECT noantrian FROM (
                SELECT
                ROW_NUMBER() OVER (ORDER BY rj.no_reg ASC) AS noantrian, rj.no_reg, rj.kd_poliklinik
                FROM dbo.Registrasi as r inner join dbo.Rawat_Jalan as rj on r.no_reg=rj.no_reg where rj.kd_poliklinik='".$data->kd_poliklinik."' and r.tgl_reg = '".formatTgl($data->tgl_reg)."'
            )  AS regis_pasien
            WHERE no_reg = '".$data->no_reg."'
            ");
        } else {
            $result = [];
        }
      
        return $result;
    }

    public function getDataRegistrasi($noReg)
    {
        // dd($noReg);
        $data = DB::table('registrasi as r')
                    ->select('r.no_reg','r.tgl_reg','r.no_rm','p.alamat','sb.no_sjp','sb.cob','sb.kd_diagnosa','sb.nama_faskes','kl.nama_kelurahan',
                            'kc.nama_kecamatan','kb.nama_kabupaten','pr.nama_propinsi')
                    ->join('sep_bpjs as sb', function($join) {
                        $join->on('r.no_reg', '=', 'sb.no_reg');
                    })
                    ->join('pasien as p', function($join) {
                        $join->on('r.no_rm', '=', 'p.no_rm');
                    })
                    ->join('kelurahan as kl', function($join) {
                        $join->on('p.kd_kelurahan', '=', 'kl.kd_kelurahan');
                    })
                    ->join('kecamatan as kc', function($join) {
                        $join->on('kl.kd_kecamatan','=','kc.kd_kecamatan');
                    })
                    ->join('kabupaten as kb', function($join) {
                        $join->on('kc.kd_kabupaten','=','kb.kd_kabupaten');
                    })
                    ->join('propinsi as pr', function($join) {
                        $join->on('kb.kd_propinsi','=','pr.kd_propinsi');
                    })
                ->where('r.no_reg', $noReg)->first();
        return $data;
    }

    public function printSep2($noReg)
    {
        $data = DB::table('registrasi as r')
                    ->select('r.no_reg','r.no_rm','r.jns_rawat','r.tgl_reg','p.nama_pasien','p.alamat','p.tgl_lahir',
                             'sb.no_sjp','sb.nama_faskes','sb.nama_diagnosa','sb.kd_diagnosa','sb.catatan',
                             'sb.cob','sb.nama_kelas_rawat','pp.no_kartu','kl.nama_kelurahan','kc.nama_kecamatan','kb.nama_kabupaten','pr.nama_propinsi')
                // ->select('sb.*', 'r.no_rm', 'r.jns_rawat', 'p.nama_pasien','p.alamat', 'p.tgl_lahir', 'pp.no_kartu', 
                //         'kl.nama_kelurahan','kc.nama_kecamatan', 'kb.nama_kabupaten','pr.nama_propinsi')
                    ->join('sep_bpjs as sb', function($join) {
                        $join->on('r.no_reg', '=', 'sb.no_reg');
                    })
                    ->join('pasien as p', function($join) {
                        $join->on('r.no_rm', '=', 'p.no_rm');
                    })
                    ->join('penjamin_pasien as pp', function($join) {
                        $join->on('r.no_rm', '=', 'pp.no_rm')
                            ->where('pp.aktif', '=', 1);
                    })
                    ->join('kelurahan as kl', function($join) {
                        $join->on('p.kd_kelurahan', '=', 'kl.kd_kelurahan');
                    })
                    ->join('kecamatan as kc', function($join) {
                        $join->on('kl.kd_kecamatan','=','kc.kd_kecamatan');
                    })
                    ->join('kabupaten as kb', function($join) {
                        $join->on('kc.kd_kabupaten','=','kb.kd_kabupaten');
                    })
                    ->join('propinsi as pr', function($join) {
                        $join->on('kb.kd_propinsi','=','pr.kd_propinsi');
                    })
                ->where('r.no_reg', $noReg)->first();
                // dd($data);
                
        if (noReg($data->no_reg) == "02") {
            $data->nama_poli = "-";
        } else {
            $poli =  DB::table('rawat_jalan as rj')->select('su.nama_sub_unit as nama_klinik','rj.kd_poliklinik')
                            ->join('sub_unit as su', function($join) {
                                $join->on('rj.kd_poliklinik', '=', 'su.kd_sub_unit');  
                            })
                            ->where('no_reg', '=', $data->no_reg)
                            ->first();
            $data->nama_poli = $poli->nama_klinik;
            $data->kd_poliklinik = $poli->kd_poliklinik;
            
        }
        $peserta = $this->conn->getPeserta($data->no_kartu,formatTgl($data->tgl_reg));
        $peserta = json_decode($peserta);
        $jnsPeserta = $peserta->response->peserta->jenisPeserta->keterangan;
        $pesertaPrb = $peserta->response->peserta->informasi->prolanisPRB;
        // $antrian = DB::table('antrian')->where('no_reg', '=', $data->no_reg)->first();
        $antrian = $this->noAntrianPoli($data);
        // dd($antrian[0]->noantrian);
        // dd($data);
        $data->prb = !is_null($pesertaPrb) ? $pesertaPrb : "";
        $data->antrian = isset($antrian) ? $antrian[0]->noantrian : "-";
        $data->jns_peserta = $jnsPeserta;
        $data->alamat = $data->alamat.' Kel.'.$data->nama_kelurahan.' Kec.'.$data->nama_kecamatan.' Kab.'.$data->nama_kabupaten.' Prov.'.$data->nama_propinsi;
        unset($data->nama_kecamatan,$data->nama_kelurahan,$data->nama_kabupaten, $antrian);
        $genPdf = PDF::loadView('pdf.invoiceSep', array('data' => $data));
        return $genPdf->stream('No SEP'.$data->no_sjp.'.pdf');
    }
}