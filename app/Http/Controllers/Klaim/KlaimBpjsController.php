<?php

namespace App\Http\Controllers\Klaim;

use App\Exports\EklaimExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\Sep\Eklaim;
use App\Service\Bpjs\Sep as cetak;
use App\Service\Bpjs\Rujukan;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use DB;
Use DateTime;
// use PDF;
use Auth;
use Virusphp\Zipper\Zipper;
use Telegram;

class KlaimBpjsController extends Controller
{
    protected $conn, $cetak, $reg, $rujukan, $eklaim;

    public function __construct()
    {
        $this->cetak = new cetak();
        $this->rujukan = new rujukan();
        $this->eklaim = new Eklaim();
    }

    public function getUpdates()
    {
        $updates = Telegram::getUpdates();
        return (json_encode($updates));
    }

    public function index()
    {
        return view('simrs.verifikasi.index');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $no = 1;
            $user = Auth::user()->role;
            $userUpload = Auth::user()->kd_pegawai;
            $data = $this->eklaim->getView($request);
            // dd($data);
            foreach($data as $q) {
                $tgl = new DateTime($q->tgl_sep);
                // $fileClaim =  asset($this->getDestination($q->tgl_sep). $q->file_claim);

                // dd($this->getDestination($q->tgl_pulang).$q->file_claim,$this->getDestination($q->tgl_sep).$q->file_claim, storage::exists('public'. DIRECTORY_SEPARATOR .$this->getDestination($q->tgl_pulang) . $q->file_claim));
                if (storage::exists('public'. DIRECTORY_SEPARATOR .$this->getDestination($q->tgl_sep) . $q->file_claim)) {
                    $fileClaim =  asset('storage'. DIRECTORY_SEPARATOR .$this->getDestination($q->tgl_sep). $q->file_claim);
                    $file = "ada";
                } else if(storage::exists('public'. DIRECTORY_SEPARATOR .$this->getDestination($q->tgl_pulang) . $q->file_claim)){
                    $fileClaim =  asset('storage'. DIRECTORY_SEPARATOR .$this->getDestination($q->tgl_pulang). $q->file_claim);
                    $file = "ada";
                } else {
                    $fileClaim =  asset('storage'. DIRECTORY_SEPARATOR .$this->getDestination($q->tgl_pulang). $q->file_claim);
                    $file = "Tidak ada";
                }
                // dd();
                if ($q->periksa == 0 && ($user == "developer" || $user == "admin" || $user == "bpjs" || $userUpload == $q->user_created) )  {
                    $btnVerified = '<button type="button" value="1" data-nilai="1" data-reg="'.$q->no_reg.'" class="btn btn-sm btn-primary" id="verifikasi-eklaim">Verify</button>
                                     <input type="checkbox" id="ver-eklaim" disabled>';
                    $btnAction = '<button type="button" value="'.$fileClaim.'" data-nilai="1" data-reg="'.$q->no_reg.'" class="btn btn-sm btn-block btn-outline-dark" id="viewer-eklaim">
                                <i class="icon-eye"></i>
                                </button>';
                } else if ($q->checked == 0 && $user == "operator") {
                    // $btnVerified = '<button type="button" class="btn btn-sm btn-primary" disabled>Verified</button>
                    //                  <input type="checkbox" id="ver-eklaim" disabled>';
                    $btnVerified = '<button type="button" value="1" data-nilai="1" data-reg="'.$q->no_reg.'" class="btn btn-sm btn-primary" id="checklist-eklaim">Ceklist</button>
                                     <input type="checkbox" id="check-eklaim" disabled>';
                    $btnAction = '<button type="button" value="'.$fileClaim.'" data-nilai="1" data-reg="'.$q->no_reg.'" class="btn btn-sm btn-block btn-outline-dark" id="viewer-eklaim">
                                <i class="icon-eye"></i>
                                </button>';
                } else if ($q->periksa == 1 && ($user == "developer" || $user == "admin" || $user == "bpjs" || $userUpload == $q->user_created)){
                    $btnVerified = '<button type="button" value="0" data-nilai="0" data-reg="'.$q->no_reg.'" class="btn btn-sm btn-success" id="verifikasi-eklaim">Verified</button>
                                    <input type="checkbox" id="ver-eklaim" checked disabled> ';
                    $btnAction = '<button type="button" value="'.$fileClaim.'" data-nilai="0" data-reg="'.$q->no_reg.'" class="btn btn-sm btn-block btn-outline-dark" id="viewer-eklaim">
                                <i class="icon-eye"></i>
                                </button>';
                } else if ($q->checked == 1 && $user == "operator") {
                    $btnVerified = '<button type="button" value="0" data-nilai="0" data-reg="'.$q->no_reg.'" class="btn btn-sm btn-success" id="checklist-eklaim">Unchecklist</button>
                                    <input type="checkbox" id="check-eklaim" checked disabled> ';
                    $btnAction = '<button type="button" value="'.$fileClaim.'" data-nilai="0" data-reg="'.$q->no_reg.'" class="btn btn-sm btn-block btn-outline-dark" id="viewer-eklaim">
                                <i class="icon-eye"></i>
                                </button>';
                } else if ($q->periksa == 2 && ($user == "developer" || $user == "admin" || $user == "bpjs" || $userUpload == $q->user_created)) {
                    $btnVerified = '<button type="button" value="1" data-nilai="1" data-reg="'.$q->no_reg.'" class="btn btn-sm btn-secondary" id="verifikasi-eklaim">Pending</button>
                                    <input type="checkbox" id="ver-eklaim" checked disabled> ';
                    $btnAction = '<button type="button" value="'.$fileClaim.'" data-nilai="1" data-reg="'.$q->no_reg.'" class="btn btn-sm btn-block btn-outline-dark" id="viewer-eklaim">
                                <i class="icon-eye"></i>
                                </button>';
                } else {
                    $btnVerified = '<button type="button" class="btn btn-sm btn-success" disabled>Verified</button>
                    <input type="checkbox" id="ver-eklaim" checked disabled> ';
                    $btnAction = '<button type="button" value="'.$fileClaim.'" data-nilai="0" data-reg="'.$q->no_reg.'" class="btn btn-sm btn-block btn-outline-dark" id="viewer-eklaim">
                                <i class="icon-eye"></i>
                                </button>';
                }
                    // 'tgl_sep'     => date('d-m-Y', strtotime($q->tgl_sep)),
                $checkbox = '<td><input data-reg="'.$q->no_reg.'" type="checkbox" value="1" name="checkModule[]" class="check-access" id="check-access"> </td>';
              
                
                $catatan = '<button type="button" value="'.$q->no_reg.'" class="btn btn-sm btn-block btn-outline-dark" id="viewer-catatan">
                             Catatan
                           </button>';
                $query[] = [
                    'list_check'  => $checkbox,
                    'no'          => $no++,
                    'no_kartu'    => $q->no_kartu,
                    'sep'         => $q->no_sep,
                    'no_rm'       => $q->no_rm,
                    'nama_pasien' => $q->nama_pasien,
                    'tgl_sep'     => date('d-m-Y', strtotime($q->tgl_sep)),
                    'tgl_plg'     => date('d-m-Y', strtotime($q->tgl_pulang)),
                    'aksi'        => $btnAction,
                    'checked'     => $btnVerified,
                    'catatan'     => $catatan,
                    'user'        => $user == "operator" ? $file : $q->user_verified
                    // 'checked' => $btnCheck,
                ];
            }
            $result = isset($query) ? ['data' => $query] : ['data' => 0];
            return json_encode($result);
        } 
    }

    public function verified(Request $request)
    {
        if ($request->ajax())
        {
            $editKlaim = $this->eklaim->cari($request->no_reg);

            if ($editKlaim) {
                $result = $this->eklaim->verified($request);
            } else {
                $result = ['kode' => 201, 'pesan' => 'Data yang di edit tidak di temukan'];
            }
        }
        return response()->json($result);
    }

    public function catatan(Request $request)
    {
        if ($request->ajax()) {
            $eklaim = $this->eklaim->cari($request->no_reg);
            if ($eklaim) {
                $result = $eklaim;
            } else {
                $result = ['kode' => 201, 'pesan', 'Data tidak di temukan'];
            }
        }
        return response()->json($result);
    }

    public function checked(Request $request)
    {
        if ($request->ajax())
        {
            $editKlaim = $this->eklaim->cari($request->no_reg);

            if ($editKlaim) {
                $result = $this->eklaim->checked($request);
            } else {
                $result = ['kode' => 201, 'pesan' => 'Data yang di edit tidak di temukan'];
            }
        }
        return response()->json($result);
    }
    

    public function verifiedall(Request $request)
    {
        if ($request->ajax()) {
            $nilai = $request->periksa;
            $data = $request->data;
            
            foreach($data as $key => $val) {
               $editKlaim = $this->eklaim->cari($val);
                
               if ($editKlaim) {
                $result = $this->eklaim->updateAll($nilai, $val);
               }
            }

            if ($result) {
                $response = $this->eklaim->Message($result, "update");
            } else {
                $response = ['kode' => 201, 'pesan' => 'Data yang di edit tidak di temukan'];
            }
        }

        return response()->json($response);
    }

    public function getNas($path)
    {
        $testNas = "11.11.12.2". \DIRECTORY_SEPARATOR. "eklaim" . \DIRECTORY_SEPARATOR. $path . \DIRECTORY_SEPARATOR . "1105R0010120V000002_AGUS_SUSILO_650627.pdf";
        return $testNas;
    }

    public function download(Request $request)
    { 
        // dd(formatTgl($request->tgl_awal), formatTgl($request->tgl_akhir), $request->status_verified);
        $data = DB::table('sep_claim')
        ->whereBetween('tgl_pulang', [
            formatTgl($request->tgl_awal), 
            formatTgl($request->tgl_akhir)
        ])
        ->where([
            ['jns_pelayanan', $request->jenisRawat],
            ['periksa', $request->status_verified],
        ])
        ->get();
        $files = [];
        foreach($data as $val) {
            $file = $this->getOriginalDestination($val->tgl_pulang);
            $datas = glob($file. $val->file_claim);
            foreach ($datas as $key => $val) {
               array_push($files, $val);
            }
        }

        foreach($data as $val)
        {
            $file = $this->getOriginalDestination($val->tgl_sep);
            $datas = glob($file. $val->file_claim);
            foreach ($datas as $key => $val) {
               array_push($files, $val);
            }
        }
  
        // $dates = dateRange($request->tgl_awal, $request->tgl_akhir);
        // // dd($dates);
        // $files = [];
        // foreach($dates as $val) {
        //     $file = $this->getOriginalDestination($val);
        //     dd($file);
        //     $datas = glob($file. '*');
          
        //     foreach ($datas as $key => $val) {
        //         array_push($files, $val);
        //     //   dd($val);
        //     }
        // }
        // dd($files);
        $headers = array(
            'Content-Type' => 'application/zip',
        );
        $fileName = tanggalPdf($request->tgl_awal)."_".tanggalPdf($request->tgl_akhir).'.zip';
        $zip = new Zipper();
        $zip->make('download'.DIRECTORY_SEPARATOR.$fileName)->add($files)->close();
        return response()->download(public_path('download'.DIRECTORY_SEPARATOR.$fileName),$fileName, $headers)->deleteFileAfterSend();
    }

    public function getDestinationNas($tgl)
    {
        return "11.11.12.2". \DIRECTORY_SEPARATOR. "eklaim" . \DIRECTORY_SEPARATOR. tanggalPdf($tgl)  . \DIRECTORY_SEPARATOR;
    }

    public function getOriginalDestination($tanggal)
    {
        return 'storage'. DIRECTORY_SEPARATOR .'verifikasi'. DIRECTORY_SEPARATOR .tanggalPdf($tanggal). DIRECTORY_SEPARATOR;
    }

    public function getDestination($tanggal)
    {
        return 'verifikasi' . DIRECTORY_SEPARATOR . tanggalPdf($tanggal) . DIRECTORY_SEPARATOR;
    }

    public function Export(Request $request)
    {
        return Excel::download(new EklaimExport($request), 'Export-Eklaim-' .$request->tgl_plg.'.xls'); 
    }

    public function printSep2($noReg)
    {
        $data = $this->getDataRegistrasi($noReg);
        $dataPasien = $this->getDataPasien($noReg);
        // dd($dataPasien);
        $data->alamat = $dataPasien->alamat.' Kel.'.$dataPasien->nama_kelurahan.' Kec.'.$dataPasien->nama_kecamatan.' Kab.'.$dataPasien->nama_kabupaten.' Prov.'.$dataPasien->nama_propinsi;
        if (noReg($dataPasien->no_reg) == "02") {
            $data->nama_poli = "-";
            $data->antrian   = "-";
        } else if (noReg($dataPasien->no_reg) == "03") {
            $data->nama_poli = "INSTALASI GAWAT DARURAT";
            $data->antrian =  "-";
        } else {
            $poli = DB::table('rawat_jalan as rj')->select('su.nama_sub_unit as nama_klinik','rj.kd_poliklinik')
                            ->join('sub_unit as su', function($join) {
                                $join->on('rj.kd_poliklinik', '=', 'su.kd_sub_unit');  
                            })
                            ->where('no_reg', '=', $dataPasien->no_reg)
                            ->first();

            $data->nama_poli = $poli->nama_klinik;
            $dataPasien->kd_poliklinik = $poli->kd_poliklinik;
            $antrian = $this->noAntrianPoli($dataPasien);
            // dd($antrian);
            $data->antrian = isset($antrian) != 0 ? $antrian[0]->noantrian : "-";
        }
        // dd($antrian)
        $req = $this->cetak->cariSep(trim($data->no_sjp));
        unset($data->nama_kecamatan,$data->nama_kelurahan,$data->nama_kabupaten, $antrian, $data->nama_propinsi,$data->tgl_reg, $data->kd_poliklinik,$data->no_sjp);
        $dataSep = json_decode($req);
        $dataSep = $dataSep->response;
        // dd($dataSep);
        $reqPeserta = $this->cetak->getPeserta($dataSep->peserta->noKartu, $dataSep->tglSep);
        $peserta = json_decode($reqPeserta);
        $informasi = $peserta->response->peserta->informasi;
        $dataSep->noReg = $dataPasien->no_reg;
        $dataSep->noMr = $dataPasien->no_rm;
        $dataSep->alamat = $data->alamat;
        // $dataSep->kdDiagnosa = $data->kd_diagnosa;
        $dataSep->namaKlinik = $data->nama_poli;
        $dataSep->antrian = $data->antrian;
        $dataSep->asalFaskes = $peserta->response->peserta->provUmum->nmProvider;
        // $dataSep->asalFaskes = $data->nama_faskes;
        // $genPdf = PDF::loadView('pdf.invoiceSep', array('data' => $dataSep));
        // return $genPdf->stream('No SEP'.$dataSep->noSep.'.pdf');
        return view('pdf.invoiceSep', compact('dataSep', 'informasi'));
    }
    
    public function noAntrianPoli($data)
    {
        if (!empty($data->kd_poliklinik)) {
              $result = $this->reg->getNoAntrian($data->no_reg, $data->kd_poliklinik, $data->tgl_reg);
        } else {
            $result = [];
        }
        return $result;
    }

    public function getDataRegistrasi($noReg)
    {
        $data = DB::table('registrasi as r')
                ->select('r.no_sjp')
            ->where('r.no_reg', $noReg)->first();
        return $data;
    }

    public function getDataPasien($noReg)
    {
        $data = DB::table('registrasi as r')
                    ->select('r.no_reg','r.tgl_reg','r.no_rm','p.alamat','kl.nama_kelurahan',
                            'kc.nama_kecamatan','kb.nama_kabupaten','pr.nama_propinsi')
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

    public function printSep($noReg)
    {
        $data = $this->getDataRegistrasi($noReg);
        $dataPasien = $this->getDataPasien($noReg);
        $data->alamat = $dataPasien->alamat.' Kel.'.$dataPasien->nama_kelurahan.' Kec.'.$dataPasien->nama_kecamatan.' Kab.'.$dataPasien->nama_kabupaten.' Prov.'.$dataPasien->nama_propinsi;
        if (noReg($dataPasien->no_reg) == "02") {
            $data->nama_poli = "-";
            $data->antrian =  "-";
        } else if (noReg($dataPasien->no_reg) == "03") {
            $data->nama_poli = "INSTALASI GAWAT DARURAT";
            $data->antrian =  "-";
        } else {
            $poli = DB::table('rawat_jalan as rj')->select('su.nama_sub_unit as nama_klinik','rj.kd_poliklinik')
                            ->join('sub_unit as su', function($join) {
                                $join->on('rj.kd_poliklinik', '=', 'su.kd_sub_unit');  
                            })
                            ->where('no_reg', '=', $dataPasien->no_reg)
                            ->first();

            $data->nama_poli = $poli->nama_klinik;
            $dataPasien->kd_poliklinik = $poli->kd_poliklinik;
            $antrian = $this->noAntrianPoli($dataPasien);
            // dd($antrian);
            $data->antrian = isset($antrian) != 0 ? $antrian[0]->noantrian : "-";
        }
        // dd($antrian)
        $req = $this->cetak->cariSep(trim($data->no_sjp));
        unset($data->nama_kecamatan,$data->nama_kelurahan,$data->nama_kabupaten, $antrian, $data->nama_propinsi,$data->tgl_reg, $data->kd_poliklinik,$data->no_sjp);
        $dataSep = json_decode($req);
        $dataSep = $dataSep->response;
        // dd($dataSep);
        $reqPeserta = $this->cetak->getPeserta($dataSep->peserta->noKartu, $dataSep->tglSep);
        $peserta = json_decode($reqPeserta);
        if ($peserta->response == null) {
            $informasi = "-";
        } else {
            $informasi = $peserta->response->peserta->informasi;
        }
        $dataSep->noReg = $dataPasien->no_reg;
        $dataSep->noMr = $dataPasien->no_rm;
        $dataSep->alamat = $data->alamat;
        // $dataSep->kdDiagnosa = $data->kd_diagnosa;
        $dataSep->namaKlinik = $data->nama_poli;
        $dataSep->antrian = $data->antrian;
        $dataSep->asalFaskes = $peserta->response->peserta->provUmum->nmProvider;
        // $genPdf = PDF::loadView('pdf.invoiceSep', compact('dataSep', 'informasi'));
        $localDestination = 'public'.DIRECTORY_SEPARATOR.'verifikasi'.DIRECTORY_SEPARATOR.$dataSep->noMr.'_'.tanggal($dataSep->tglSep).DIRECTORY_SEPARATOR;
        // Storage::put($localDestination.$dataSep->noSep.'.pdf', $genPdf->output());
        // File::move($path_source, $path_dest);
        // return $genPdf->stream('No SEP'.$dataSep->noSep.'.pdf');
    }

    public function printRujukan($noSep)
    {
        $req = $this->cetak->cariSep(trim($noSep));
        $dataSep = json_decode($req);
        $dataSep = $dataSep->response;
        $noRujukan = $dataSep->noRujukan;
        $request = $this->rujukan->getRujukan($noRujukan);
        $dataRujukan = json_decode($request);
        $rujukan = $dataRujukan->response; 
        if ($rujukan == null) {
            $request = $this->rujukan->getRujukanRs($noRujukan);
            $dataRujukan = json_decode($request);
            $rujukan = $dataRujukan->response; 
        } 
        // $rujukan = $rujukan;
        // dd($rujukan);
        // $genPdf = PDF::loadView('pdf.rujukan', compact('rujukan'), [], ['format' => [190, 100]]);
        // return $genPdf->stream('No SEP'.$dataSep->noSep.'.pdf');
    }
}