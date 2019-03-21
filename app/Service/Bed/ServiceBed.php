<?php
namespace App\Service\Bed;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use DB;
use GuzzleHttp\Psr7;
use Guzzle\Http\Message\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

class ServiceBed 
{
    protected $client = null;
    protected $api_url;
    protected $urlencode;

    public function __construct()
    {
        $this->client = new Client(['cookies' => true, 'verify' => false]);  
        $this->urlencode = array('Content-Type' => 'Application/json');  
        $this->api_url = config('bpjs.api.endpoint');   
        $this->api_kamar_url = config('bpjs.api.kamar');   
    }

    public function getBed()
    {
        try { 
            $url = $this->api_url . "data/bed";
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

    public function postBed($data)
    {
        try {
            $url = $this->api_kamar_url . "kamar/create/1105R001";
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

    public function updateBed($data)
    {
        try {
            $url = $this->api_kamar_url . "kamar/update/1105R001";
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

    public function deleteBed($data)
    {
        try {
            $url = $this->api_kamar_url . "kamar/delete/1105R001";
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
}
