<?php

namespace App\Http\Controllers\Klaim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\Sep\Registrasi;
use App\Repository\Poli\Poli;
use App\Repository\Pasien\Pasien;
use App\Service\Bpjs\Sep as Cetak;
use Illuminate\Support\Facades\Storage;
use App\Repository\Rujukan as RujukanInternal;
use App\Service\Bpjs\Rujukan;
use PDF;
use DB;
use Illuminate\Support\Str;

class VerifikasiController extends Controller
{
    protected $reg, $sep, $poli, $pasien, $rujukan, $surat;

    public function __construct()
    {
        $this->cetak = new Cetak();
        $this->poli = new Poli();
        $this->reg = new Registrasi();
        $this->pasien = new Pasien();
        $this->rujukan = new Rujukan();
        $this->surat = new RujukanInternal();
    }

    public function detailPeserta($noReg)
    {
        $data = $this->reg->getDataRegistrasi($noReg);
        $checkSep = DB::table('klaim_sep')->where('no_reg', $noReg)->first();
        if ($checkSep) {
            $req = $this->cetak->cariSep(trim($data->no_sjp));
            $dataPeserta = $this->dataSep($req, $noReg);
            $dataPeserta->pdfSep = $checkSep->file_pdf;
            // $dataRujukan = json_decode($this->getRujukan($dataPeserta->noRujukan, $dataPeserta->tglSep, $noReg, $dataPeserta->no_rm, $dataPeserta->nama));
        } else {
            $req = $this->cetak->cariSep(trim($data->no_sjp));
            $dataPeserta = $this->dataSep($req, $noReg);
            $dataPeserta->pdfSep = tanggalPdf($dataPeserta->tglSep) . '/' . $dataPeserta->no_rm . '_' . Str::slug($dataPeserta->nama) . '.pdf';
            $this->getSep($noReg);
            // $dataRujukan = json_decode($this->getRujukan($dataPeserta->noRujukan, $dataPeserta->tglSep, $noReg, $dataPeserta->no_reg, $dataPeserta->nama));
            // dd($checkSep);
        }

        $dataRujukan = DB::table('klaim_rujukan')->where('no_reg', $noReg)->first();
        if ($dataRujukan) {
            $dataRujukan->status = 1;
            $dataRujukan->pesan = $dataRujukan->file_pdf;
            // dd($dataRujukan);
        } else {
            $dataRujukan = json_decode($this->getRujukan($dataPeserta->noRujukan, $dataPeserta->tglSep, $dataPeserta->no_rm, $noReg, $dataPeserta->nama));
        }

        $dataSuratKontrol = DB::table('surat_rujukan_internal as sri')
            ->select('sri.no_rujukan as no_surat', 'ksu.no_sep')
            ->leftJoin('klaim_surat_kontrol as ksu', 'sri.no_rujukan', '=', 'ksu.no_surat')
            ->where('sri.no_rujukan_bpjs', $dataPeserta->noRujukan)->get();

        // dd($dataPeserta,$dataRujukan);
        return view('simrs.peserta.detail', compact('noReg', 'dataPeserta', 'dataRujukan', 'dataSuratKontrol'));
    }

    public function dataSep($data, $noReg)
    {
        $dataPeserta            = $this->pasien->getDataPasien($noReg);
        $dataSep                = json_decode($data);
        $dataPeserta->noSep     = $dataSep->response->noSep;
        $dataPeserta->noKartu   = $dataSep->response->peserta->noKartu;
        $dataPeserta->hakKelas  = $dataSep->response->peserta->hakKelas;
        $dataPeserta->nama      = $dataSep->response->peserta->nama;
        $dataPeserta->tglSep    = $dataSep->response->tglSep;
        $dataPeserta->noRujukan = $dataSep->response->noRujukan;
        // unset($data, $dataSep);
        return $dataPeserta;
    }

    public function getSuratInternal(Request $request)
    {
        // dd($request->all());
            $noRm = $request->noRm;
            $surat = $this->surat->getSurat($request);
            dd($noRm, $surat);
            // $noSurat = substr($surat->no_rujukan,6,6);
            // $genPdf = PDF::loadView('pdf.surat', compact('surat'), [], ['format' => [190, 100]]);
            // return $genPdf->stream('No Surat_'.$noSurat.'.pdf');
            return redirect()->back();
    }

    public function printSurat($tglSep, $noSurat, $noRujukan)
    {
        // $surat = $this->surat->getSurat2($noSurat, $noRujukan);
        // if ($surat) {
        //     $noSurat = substr($surat->no_rujukan,6,6);
        //     $urlDestination = tanggalPdf($tglSep) . '/';
        //     $fileName = $noRm
        // }
        // $genPdf = PDF::loadView('pdf.surat', compact('surat'), [], ['format' => [190, 100]]);
        // return $genPdf->stream('No Surat_'.$noSurat.'.pdf');
    }

    public function getRujukan($noRujukan, $tglSep, $noRm, $noReg, $nama)
    {
        $request = $this->rujukan->getRujukan($noRujukan);
        $dataRujukan = json_decode($request);
        $rujukan = $dataRujukan->response;
        // dd($rujukan);
        if ($rujukan != null) {
            $urlDestination = tanggalPdf($tglSep) . '/';
            $fileName = $noRm . '_' . Str::slug($nama) . '_' . $noRujukan . '.pdf';
            // dd($localDestination);
            $simpanKlaim = DB::table('klaim_rujukan')->insert([
                'no_reg'      => $noReg,
                'no_rujukan'  => $noRujukan,
                'no_rm'       => $noRm,
                'tgl_rujukan' => $rujukan->rujukan->tglKunjungan,
                'file_pdf'    => $urlDestination . $fileName
            ]);
            // dd($rujukan);
            $localDestination = $this->getDestination($tglSep);
            $status           = ['status' => 1, 'pesan' => tanggalPdf($tglSep) . '/' . $fileName];
            $genPdf           = PDF::loadView('pdf.rujukan', compact('rujukan'), [], ['format' => [190, 100]]);
            Storage::put($localDestination . $fileName, $genPdf->output());
            // dd("disini");
        } else {
            $request     = $this->rujukan->getRujukanRs($noRujukan);
            $dataRujukan = json_decode($request);
            $rujukan     = $dataRujukan->response;
            if ($rujukan == null) {
                $status = ['status' => 0, 'pesan' => 'Pasien dari Post Opname'];
            } else {
                $urlDestination = tanggalPdf($tglSep) . '/';
                $fileName = $noRm . '_' . Str::slug($nama) . '_' . $noRujukan . '.pdf';
                // dd($localDestination);
                $simpanKlaim = DB::table('klaim_rujukan')->insert([
                    'no_reg'      => $noReg,
                    'no_rujukan'  => $noRujukan,
                    'no_rm'       => $noRm,
                    'tgl_rujukan' => $rujukan->rujukan->tglKunjungan,
                    'file_pdf'    => $urlDestination . $fileName
                ]);

            // dd($rujukan);
                $localDestination = $this->getDestination($tglSep);
                $status           = ['status' => 1, 'pesan' => tanggalPdf($tglSep) . '/' . $fileName];
                $genPdf           = PDF::loadView('pdf.rujukan', compact('rujukan'), [], ['format' => [190, 100]]);
                Storage::put($localDestination . $fileName, $genPdf->output());
            }
        }
        // dd($status);
        return json_encode($status);
    }

    public function getSep($noReg)
    {
        $data = $this->reg->getDataRegistrasi($noReg);
        $dataPasien = $this->pasien->getDataPasien($noReg);
        $data->alamat = $dataPasien->alamat . ' Kel.' . $dataPasien->nama_kelurahan . ' Kec.' . $dataPasien->nama_kecamatan . ' Kab.' . $dataPasien->nama_kabupaten . ' Prov.' . $dataPasien->nama_propinsi;
        if (noReg($dataPasien->no_reg) == "02") {
            $data->nama_poli = "-";
            $data->antrian =  "-";
        } else if (noReg($dataPasien->no_reg) == "03") {
            $data->nama_poli = "INSTALASI GAWAT DARURAT";
            $data->antrian =  "-";
        } else {
            $poli = $this->poli->getPoliklinik($dataPasien->no_reg);

            $data->nama_poli           = $poli->nama_klinik;
            $dataPasien->kd_poliklinik = $poli->kd_poliklinik;
            $antrian                   = $this->noAntrianPoli($dataPasien);
            $data->antrian             = isset($antrian) != 0 ? $antrian[0]->noantrian : "-";
        }
        // dd($antrian)
        $req = $this->cetak->cariSep(trim($data->no_sjp));
        unset($data->nama_kecamatan, $data->nama_kelurahan, $data->nama_kabupaten, $antrian, $data->nama_propinsi, $data->tgl_reg, $data->kd_poliklinik, $data->no_sjp);
        $dataSep    = json_decode($req);
        $dataSep    = $dataSep->response;
        $reqPeserta = $this->cetak->getPeserta($dataSep->peserta->noKartu, $dataSep->tglSep);
        $peserta    = json_decode($reqPeserta);
        if ($peserta->response == null) {
            $informasi = "-";
        } else {
            $informasi = $peserta->response->peserta->informasi;
        }
        $dataSep->noReg      = $dataPasien->no_reg;
        $dataSep->noMr       = $dataPasien->no_rm;
        $dataSep->alamat     = $data->alamat;
        $dataSep->namaKlinik = $data->nama_poli;
        $dataSep->antrian    = $data->antrian;
        $dataSep->asalFaskes = $peserta->response->peserta->provUmum->nmProvider;

        $localDestination = $this->getDestination($dataSep->tglSep);
        $urlDestination = tanggalPdf($dataSep->tglSep) . '/';
        $fileName = $dataSep->noMr . '_' . Str::slug($dataSep->peserta->nama) . '.pdf';

        $simpanKlaim = DB::table('klaim_sep')->insert([
            'no_reg'     => $dataSep->noReg,
            'no_sep'     => $dataSep->noSep,
            'no_rujukan' => $dataSep->noRujukan,
            'tgl_sep'    => $dataSep->tglSep,
            'file_pdf'   => $urlDestination . $fileName
        ]);

        $genPdf = PDF::loadView('pdf.invoiceSep', compact('dataSep', 'informasi'));
        Storage::put($localDestination . $fileName, $genPdf->output());
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

    public function getDestination($tanggal)
    {
        return 'public' . DIRECTORY_SEPARATOR . 'verifikasi' . DIRECTORY_SEPARATOR . tanggalPdf($tanggal) . DIRECTORY_SEPARATOR;
    }
}
