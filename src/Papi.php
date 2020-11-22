<?php

namespace Blashbrook\Papi;

use Carbon\Carbon;
use GuzzleHttp\Client;

class Papi extends Client
{

    /**
     * Creates value and hash signature for PAPI Request Authorization header.
     *
     * @param $method - HTTP Request method (GET|POST|PUT)
     * @param $uri
     *- HTTP Request URI
     * @param $papiDate - Polaris server local date and time
     * @return string
     *
     */
    static protected function getHash($method, $uri, $papiDate)
    {
        //
        return 'PWS ' . config('papi.id') . ':'
            . base64_encode(hash_hmac(
                'sha1',
                $method . $uri . $papiDate, config('papi.key'),
                true));
    }


    /**
     * @return string
     */
    static protected function getDate()
    {
        return Carbon::now()->format('D, d M Y H:i:s \G\M\T');
    }

     static protected function getHeaders($method, $uri)
    {
        $papiDate = self::getDate();
        $papiToken = self::getHash($method, $uri, $papiDate);
        return ['Accept' => 'application/json',
            'Authorization' => $papiToken,
            'PolarisDate' => $papiDate];
    }

    static public function publicRequest($method, $uri, $params = [null], $scope = 'public')
    {
        $base_uri = ($scope == 'protected')? config('papi.protectedURI') : config('papi.publicURI');
        $uri = $base_uri . $uri;
        $headers = self::getHeaders($method, $uri);
        $client = new Client();
        return $client->request($method, $uri,
            ['headers' => $headers,
                'json' => $params],
        );
    }

}

