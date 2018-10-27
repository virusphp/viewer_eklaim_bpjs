<?php

namespace App\Service\Registrasi;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use Guzzle\Http\Message\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use App\Repository\Pasien\Pasien as KartuPasien;

class Registrasi
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
    
    public function sendregister($data)
    {
        // $data = file_get_contents("php://input");
        try {
            $url = $this->api_url . "sendregister";
            $response = $this->client->post($url, ['form_params' => $data]);
            $result = $response->getBody();
            return $result;
        } catch (RequestException $e) {
            return Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
            return Psr7\str($e->getResponse());
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

}