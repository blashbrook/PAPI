<?php

namespace Blashbrook\Papi;


//use Blashbrook\Papi\Http\Controllers\PAPIDateController;
//use Blashbrook\Papi\Http\Controllers\PAPITokenController;
use Blashbrook\Papi\Papi;
use Illuminate\Container;
use GuzzleHttp\Client;
use Orchestra\Testbench\TestCase;
use function PHPUnit\Framework\assertStringContainsString;

class PAPIHttpRequestTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return ['Blashbrook\Papi\PapiServiceProvider'];
    }
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set(config('papi'));
    }

    public function test_if_papi_server_is_responding ()
    {
        $response = file_get_contents('https://catalog.dcplibrary.org/polaris');
        $this->assertStringContainsStringIgnoringCase('daviess county', $response);
    }

    public function test_can_read_papi_config_variables ()
    {
        $this->assertEquals('CatalogAPI', config('papi.id'));
    }

    public function test_birthdate_column_fails_if_format_is_incorrect()
    {
        $papiDate = Papi::getDate();
        $uri = config('papi.publicURI') . 'patron';
        $accessKey = config('papi.key');

        $papiToken = Papi::getHash('POST', $uri, $papiDate);
        $client = new Client();
        $response = $client->request(
            'POST',
            $uri,
            ['headers' =>
                ['Accept' => 'application/json',
                    'Authorization' => $papiToken,
                    'PolarisDate' => $papiDate],
                'json' => [
                    'LogonBranchID' => '3',
                    'LogonUserID' => '56',
                    'LogonWorkstationID' => '1',
                    'PatronBranchID' => '3',
                    'State' => 'KY',
                    'PostalCode' => '42301',
                    'Birthdate' => 'fart',
                    'NameFirst' => 'Test',
                    'NameMiddle' => 'Joe',
                    'NameLast' => 'Test',
                    'Barcode' => '0000000001',
                ],
            ]
        );

        $body = json_decode($response->getBody());
        foreach ($body as $key => $value) {
            if ($key == 'ErrorMessage') {
                $error = $value;
            }
        }
        $this->assertEqualsIgnoringCase($error, 'birthdate is invalid');
        $this->assertEquals(json_decode($response->getStatusCode()), '200');

    }

    public function test_papi_key_and_request_headers_are_valid()
    {
        $papiDate = Papi::getDate();

        //$uri = 'https://catalog.dcplibrary.org/PAPIService/REST/public/v1/1033/100/3/apikeyvalidate';

        ddd($uri = config('papi.publicURI'));
            //. 'apikeyvalidate';

        $papiToken = Papi::getHash('GET', $uri, $papiDate);

        $client = new Client();
        $response = $client->request(
            'GET',
            $uri,
            ['headers' =>
                [
                    'Accept' => 'application/json',
                    'Authorization' => $papiToken,
                    'PolarisDate' => $papiDate,
                ],
            ]);
        //ddd(json_decode($response->getHeaders()));
        $this->assertEquals(json_decode($response->getStatusCode()), '200');
    }

}
