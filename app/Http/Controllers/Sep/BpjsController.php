<?php

namespace App\Http\Controllers\Sep;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use DB;
use GuzzleHttp\Psr7;
use Guzzle\Http\Message\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

class BpjsController extends Controller
{
    protected $client = null;
    protected $api_url;

    public function __construct()
    {
        $this->client = new Client(['cookies' => true, 'verify' => false]);    
        $this->api_url = config('bpjs.api.endpoint');   
    }

    public function getRujukan(Request $req)
    {
        // return $req->rujukan;
        try {
            $url = $this->api_url . "rujukan/".$req->rujukan;
            $response = $this->client->get($url);
            $result = $response->getBody();
            return $result;
        } catch (RequestException $e) {
            $result = Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $result = Psr7\str($e->getResponse());
            }
        } 
    }

    public function getPeserta(Request $req)
    {
        try { 
            $url = $this->api_url . "peserta/nokartu/".$req->no_kartu."/tglsep"."/".$req->tgl_sep;
            $response = $this->client->get($url);
            $result = $response->getBody();
            return $result;
        } catch (RequestException $e) {
            $result = Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $result = Psr7\str($e->getResponse());
            }
        }
    }

    public function getPpkRujukan(Request $req)
    {
        $jns_faskes = "1";
        $dataAwal = $this->ppkRujukan($req->ppk_rujukan, $jns_faskes);
        $rujukan = json_decode($dataAwal);
        if ($rujukan->response == null) {
            $jns_faskes = "2";
            $data  = $this->ppkRujukan($req->ppk_rujukan, $jns_faskes);
        } else {
            $data = $dataAwal;
        }
        return $data;
    }

    public function ppkRujukan($kode, $jns)
    {
        try { 
            $url = $this->api_url . "referensi/faskes/".$kode."/".$jns;
            $response = $this->client->get($url);
            $result = $response->getBody();
            return $result;
        } catch (RequestException $e) {
            $result = Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $result = Psr7\str($e->getResponse());
            }
        }
    }

    public function getDiagnosa(Request $req)
    {
        if ($req->ajax()) {
            $kode = $req->get('term');
            $diagnosa = $this->Diagnosa($kode);
            $data = json_decode($diagnosa);
            $diagAwal = $data->response->diagnosa;
            return $diagAwal;
        }
        // $data = json_decode($diagnosa, tue);
        // // $diagnosa = "<option value='$kode'>$req->nama</option>";
        // foreach($data['response']['diagnosa'] as $d) 
        // {
        //     $diagnosa.= "<option value='$d[kode]'>$d[nama]</option>";
        // }
    }

    public function getDpjp(Request $req)
    {
        if ($req->ajax()) {
            $kode = $req->all();
            $dpjp = $this->Dpjp($kode);
            $data = json_decode($dpjp);
            if ($data->response != null) {
                $dpjp = $data->response->list;
            } else {
                $dpjp = [];
            }
            return $dpjp;
        }
    }

    public function getPoli(Request $req)
    {
        if ($req->ajax()) {
            $kode = $req->get('term');
            $poli = $this->Poli($kode);
            $data = json_decode($poli);
            $poliTujuan = $data->response->poli;
            return $poliTujuan;
        }
    }

    public function getProvinsi()
    {
        $provinsi = $this->Provinsi();
        $data = json_decode($provinsi, true);
        // dd($data['response']['list']);
        $prov="<option value='0'>--Silahkan Pilih Provinsi--</pilih>";
        foreach($data['response']['list'] as $d)
        {
            $prov.= "<option value='$d[kode]'>$d[nama]</option>";
        }
        return $prov;
    }

    public function getKabupaten(Request $req)
    {
        $kd_prov = $req->kd_prov;
        $kabupaten = $this->Kabupaten($kd_prov);
        $data = json_decode($kabupaten, true);
        $kab="<option value='0'>--Silahkan Pilih Kabupaten/Kota--</pilih>";
        foreach($data['response']['list'] as $d)
        {
            $kab.= "<option value='$d[kode]'>$d[nama]</option>";
        }
        return $kab;
    }

    public function getKecamatan(Request $req)
    {
        $kd_kab = $req->kd_kab;
        $kecamatan = $this->Kecamatan($kd_kab);
        $data = json_decode($kecamatan, true);
        // dd($data['response']);
        $kec="<option value='0'>--Silahkan Pilih Kecamatan/Kota--</pilih>";
        foreach($data['response']['list'] as $d)
        {
            $kec.= "<option value='$d[kode]'>$d[nama]</option>";
        }
        return $kec;
    }

    public function Diagnosa($kode)
    {
        try { 
            $url = $this->api_url . "referensi/diagnosa/".$kode;
            $response = $this->client->get($url);
            $result = $response->getBody();
            return $result;
        } catch (RequestException $e) {
            $result = Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $result = Psr7\str($e->getResponse());
            }
        }
    }

    public function Poli($kode)
    {
        try { 
            $url = $this->api_url . "referensi/poli/".$kode;
            $response = $this->client->get($url);
            $result = $response->getBody();
            return $result;
        } catch (RequestException $e) {
            $result = Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $result = Psr7\str($e->getResponse());
            }
        }
    }

    public function Dpjp($kode)
    {
        $tgl = date('Y-m-d');
        try { 
            $url = $this->api_url . "referensi/dokter/pelayanan/".$kode['jnsPel']."/tglpelayanan/".$tgl."/spesialis/".$kode['term'];
            $response = $this->client->get($url);
            $result = $response->getBody();
            return $result;
        } catch (RequestException $e) {
            $result = Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $result = Psr7\str($e->getResponse());
            }
        }
    }

    public function Provinsi()
    {
        try { 
            $url = $this->api_url . "referensi/provinsi";
            $response = $this->client->get($url);
            $result = $response->getBody();
            return $result;
        } catch (RequestException $e) {
            $result = Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $result = Psr7\str($e->getResponse());
            }
        }
    }

    public function Kabupaten($kd_prov)
    {
        try { 
            $url = $this->api_url . "referensi/kabupaten/provinsi/".$kd_prov;
            $response = $this->client->get($url);
            $result = $response->getBody();
            return $result;
        } catch (RequestException $e) {
            $result = Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $result = Psr7\str($e->getResponse());
            }
        }
    }

    public function Kecamatan($kd_kab)
    {
        try { 
            $url = $this->api_url . "referensi/kecamatan/kabupaten/".$kd_kab;
            $response = $this->client->get($url);
            $result = $response->getBody();
            return $result;
        } catch (RequestException $e) {
            $result = Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $result = Psr7\str($e->getResponse());
            }
        }
    }
}
