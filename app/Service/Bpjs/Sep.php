<?php
namespace App\Service\Bpjs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use DB;
use GuzzleHttp\Psr7;
use Guzzle\Http\Message\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

class Sep 
{
    protected $client = null;
    protected $api_url;

    public function __construct()
    {
        $this->client = new Client(['cookies' => true, 'verify' => false]);    
        $this->api_url = config('bpjs.api.endpoint');   
    }

    public function getPeserta($noKartu,$tglSep)
    {
        try { 
            $url = $this->api_url . "peserta/nokartu/".$noKartu."/tglsep"."/".$tglSep;
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

    public function cariSep($sep)
    {
        // dd($sep);
        try {
            $url = $this->api_url . "sep/". $sep;
            $response = $this->client->get($url);
            $result = $response->getBody();
            return $result;
        } catch (RequestException $e) {
            return Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                return Psr7\str($e->getResponse());
            }
        } 
    }

    public function saveSep($data)
    {
        
        try {
            $url = $this->api_url . "sep/insert";
            $response = $this->client->post($url, ['body' => $data]);
            $result = $response->getBody();
            return $result;
        } catch (RequestException $e) {
            return Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
            return Psr7\str($e->getResponse());
            }
        } 
 
    }

    public function updateSep($data)
    {
       
        try {
            $url = $this->api_url . "sep/update";
            $response = $this->client->put($url, ['body' => $data]);
            $result = $response->getBody();
            return $result;
        } catch (RequestException $e) {
            return Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
            return Psr7\str($e->getResponse());
            }
        } 
    }

    public function deleteSep($data)
    {
        $data = file_get_contents("php://input");
        // dd($data);
        try {
            $url = $this->api_url . "SEP/Delete";
            $response = $this->client->delete($url, ['headers' => $this->headers, 'body' => $data]);
            return $response;
        } catch (RequestException $e) {
            return Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
            return Psr7\str($e->getResponse());
            }
        } 
    }

    public function updatePulang($data)
    {
        $data = file_get_contents("php://input");
        try {
            $url = $this->api_url . "Sep/updtglplg";
            $response = $this->client->put($url, ['headers' => $this->headers, 'body' => $data]);
            return $response;
        } catch (RequestException $e) {
            return Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
            return Psr7\str($e->getResponse());
            }
        } 
    }

    public function suplesi($noKartu,$tglPel)
    {
        try {
            $url = $this->api_url . "sep/JasaRaharja/Suplesi/". $noKartu. "/tglPelayanan"."/".$tglPel;
            $response = $this->client->get($url, ['headers' => $this->header]);
            return $response;
        } catch (RequestException $e) {
            return Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                return Psr7\str($e->getResponse());
            }
        } 
    }
}
