<?php

namespace App\Service\Pasien;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use Guzzle\Http\Message\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use App\Repository\Pasien\Pasien as KartuPasien;

class Pasien
{
    protected $client = null;
    protected $api_url;
    protected $kartuPasien;

    public function __construct()
    {
        $this->client = new Client(['cookies' => true, 'verify' => false]);    
        $this->api_url = config('bpjs.api.endpoint');   
        $this->kartuPasien = new KartuPasien;
    }
    
    public function getPasien($req)
    {
        try {
            $url = $this->api_url . "getpasien/".$req->noRm;
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

    public function getKartu($req)
    {
        $kartu = $this->kartuPasien->getKartu($req);
        if ($kartu) {
            $res = $kartu;
        } else {
            $res = [
                'no_kartu' => '-'
            ];
        }
        return response()->json($res); 
    }

    public function getJnsPenjamin($kode)
    {
         // dd($kode);
         try {
            $url = $this->api_url . "getjnspenjamin/".$kode;
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