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

class Rujukan 
{
    protected $client = null;
    protected $api_url;
    protected $header;

    public function __construct()
    {
        $this->client = new Client(['cookies' => true, 'verify' => false]);    
        $this->header = array('Content-Type' => 'Application/json');  
        $this->api_url = config('bpjs.api.endpoint');   
    }

    public function getRujukan($noRujukan)
    {
        try {
            $url = $this->api_url . "rujukan/". $noRujukan;
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

    public function getRujukanRs($noRujukan)
    {
        try {
            $url = $this->api_url . "rujukan/rs/". $noRujukan;
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
}