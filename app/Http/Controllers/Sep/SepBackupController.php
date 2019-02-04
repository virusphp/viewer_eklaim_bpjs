<?php

namespace App\Http\Controllers\sep;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BackupSepController extends Controller
{
    public function printSep2($noReg)
    {
        $data = DB::table('registrasi as r')
                    ->select('r.no_reg','r.no_rm','r.jns_rawat','r.tgl_reg','p.nama_pasien','p.alamat','p.tgl_lahir',
                             'sb.no_sjp','sb.nama_faskes','sb.nama_diagnosa','sb.kd_diagnosa','sb.catatan',
                             'sb.cob','sb.nama_kelas_rawat','pp.no_kartu','kl.nama_kelurahan','kc.nama_kecamatan','kb.nama_kabupaten','pr.nama_propinsi')
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