<?php
namespace App\Service\Siranap;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DB;
use GuzzleHttp\Psr7;
use Guzzle\Http\Message\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

class ServiceSiranap 
{
    protected $client = null;
    protected $api_url;
    protected $urlencode;

    public function __construct()
    {
        $this->client = new Client(['cookies' => true, 'verify' => false]);  
        $this->urlencode = array('Content-Type' => 'application/x-www-form-urlencoded');
        $this->api_url = config('bpjs.api.endpoint');   
    }

    public function getSiranap()
    {
        try { 
            $url = $this->api_url . "siranap/json";
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

    public function updateSiranap($data)
    {
        // $data = file_get_contents("php://input");
        try {
            $url = $this->api_url . "siranap/post";
            $response = $this->client->post($url, ['headers' => $this->urlencode, 'body' => $data]);
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
