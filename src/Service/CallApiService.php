<?php

namespace App\Service;

use DateTime;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    private $client;


    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     MAKE THE API CALL TO GET COVID DATA 
    **/
    private function get_api_url_endpoint(string $var)
    {
        $response = $this->client->request(
            'GET',
            'https://api.covid19api.com/total/country/' . $var,
        );

        return $response->toArray();
    }


    /**
     RETRIEVE THE SA COVID DATA FROM THE API CALL 
    **/
    public function get_sa_data(): array
    {
        return $this->get_api_url_endpoint('south-africa');
    }


}
