<?php

namespace App\Http\Controllers\Klaim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\Sep\Eklaim;
use App\Service\Bpjs\Sep as cetak;
use App\Service\Bpjs\Rujukan;
use Illuminate\Support\Facades\Storage;
use DB;
Use DateTime;
use PDF;
use File;

class KlaimBpjsController extends Controller
{
    protected $conn, $cetak, $reg, $rujukan;

    public function __construct()
    {
        $this->cetak = new cetak();
        $this->rujukan = new rujukan();
        $this->eklaim = new Eklaim();
    }

    public function index()
    {
        return view('simrs.verifikasi.index');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $no = 1;
            $data = $this->eklaim->getView($request);
            // dd($data);
            foreach($data as $q) {
                $tgl = new DateTime($q->tgl_sep);
                $fileClaim =  asset($this->getDestination($q->tgl_sep). $q->file_claim);
                $btnAction = '<button type="button" value="'.$fileClaim.'" class="btn btn-sm btn-success" id="viewer-eklaim">Show</button>';
                $query[] = [
                    'no' => $no++,
                    'no_reg' => $q->no_reg,
                    'no_rm' => $q->no_rm,
                    'nama_pasien' => $q->nama_pasien,
                    'tgl_sep' => $tgl->format('d-m-Y'),
                    'sep' => $q->no_sep,
                    'action' => $btnAction,
                ];
            }
            $result = isset($query) ? ['data' => $query] : ['data' => 0];
            // dd($result);
            return json_encode($result);
        } 
    }

    public function getDestination($tanggal)
    {
        return 'storage/verifikasi/'.tanggalPdf($tanggal).'/';
    }

    public function printSep2($noReg)
    {
        $data = $this->getDataRegistrasi($noReg);
        $dataPasien = $this->getDataPasien($noReg);
        // dd($dataPasien);
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
        $informasi = $peserta->response->peserta->informasi;
        $dataSep->noReg = $dataPasien->no_reg;
        $dataSep->noMr = $dataPasien->no_rm;
        $dataSep->alamat = $data->alamat;
        // $dataSep->kdDiagnosa = $data->kd_diagnosa;
        $dataSep->namaKlinik = $data->nama_poli;
        $dataSep->antrian = $data->antrian;
        $dataSep->asalFaskes = $peserta->response->peserta->provUmum->nmProvider;
        // $dataSep->asalFaskes = $data->nama_faskes;
        // dd($dataSep);
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
        $genPdf = PDF::loadView('pdf.invoiceSep', compact('dataSep', 'informasi'));
        $localDestination = 'public'.DIRECTORY_SEPARATOR.'verifikasi'.DIRECTORY_SEPARATOR.$dataSep->noMr.'_'.tanggal($dataSep->tglSep).DIRECTORY_SEPARATOR;
        Storage::put($localDestination.$dataSep->noSep.'.pdf', $genPdf->output());
        // File::move($path_source, $path_dest);
        return $genPdf->stream('No SEP'.$dataSep->noSep.'.pdf');
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
        $genPdf = PDF::loadView('pdf.rujukan', compact('rujukan'), [], ['format' => [190, 100]]);
        return $genPdf->stream('No SEP'.$dataSep->noSep.'.pdf');
    }
}