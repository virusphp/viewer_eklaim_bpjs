<?php

namespace App\Service\Pasien;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use Guzzle\Http\Message\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

class Pasien
{
    protected $client = null;
    protected $api_url;

    public function __construct()
    {
        $this->client = new Client(['cookies' => true, 'verify' => false]);    
        $this->api_url = config('bpjs.api.endpoint');   
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

}