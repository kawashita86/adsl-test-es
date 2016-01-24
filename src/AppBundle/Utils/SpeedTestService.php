<?php
/**
 * Created by PhpStorm.
 * User: Francesco
 * Date: 24/01/2016
 * Time: 19:17
 */

namespace AppBundle\Utils;

class SpeedTestService {

    public $results;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * ComparaWebService constructor.
     * @param \GuzzleHttp\Client|null $client
     */
    public function __construct(\GuzzleHttp\Client $client = null)
    {
        $this->client = $client;
    }

    public function getZipFromCity($city) {
        if(empty($city))
            return array('result' => '');

        $response = $this->client->request('POST', 'find/city', ['json' => ['city' => trim($city)]]);
        return json_decode($response->getBody(), true);
    }
}