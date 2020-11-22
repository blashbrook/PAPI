<?php

namespace Blashbrook\Papi\Http\Controllers;

use App\Http\Controllers\Controller;

class PAPITokenController extends Controller
{
    /**
     * Creates value and hash signature for PAPI Request Authorization header.
     *
     * @param $method - HTTP Request method (GET|POST|PUT)
     * @param $papiURI - HTTP Request URI
     * @param $papiDate - Polaris server local date and time
     * @return string
     *
     */
    static public function getHash($method, $papiURI, $papiDate)
    {
        //
        return 'PWS ' . config('papi.id') . ':' . base64_encode(hash_hmac('sha1', $method . $papiURI . $papiDate, config('papi.key'),true));
    }
}
