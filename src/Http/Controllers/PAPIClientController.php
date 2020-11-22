<?php

namespace Blashbrook\Papi\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PAPIClientController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $papiDate = New PAPIDateController();
        $httpDate = $papiDate->getDate();
        $uri = config('papi.publicURI') . 'patron';
        $concat = 'POST' . $uri . $httpDate;
        $accessKey = config('papi.key');
        //$sha1_sig = 'PWS ' . config('papi.id') . ':' . base64_encode(hash_hmac('sha1', $concat, $accessKey, true));

        $sha1_sig = app('papiToken')->setHash('GET', $concat, $httpDate);
        //$sha1_sig
        //$client = new GuzzleHttp\Client();
        $response = $client->request(
        //$response = array(
            'POST',
            $uri,
            ['headers' =>
                ['Accept' => 'application/json',
                    'Authorization' => $sha1_sig,
                    'PolarisDate' => $httpDate],
                'json' => ['LogonBranchID' => config('papi.logonBranchID'),
                    'LogonUserID' => config('papi.logonUserID'),
                    'LogonWorkstationID' => config('papi.logonWorkstationID'),
                    'PatronBranchID' => config('papi.logonBranchID'),
                    'State' => $request['State'],
                    'NameFirst' => $request['NameFirst'],
                    'NameMiddle' => $request['NameMiddle'],
                    'NameLast' => $request['NameLast'],
                    'Barcode' => $request['Barcode'],
                ]
            ]
        );
        $response->getStatusCode();
        ddd(json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR));
        //ddd($request);
    }
}
