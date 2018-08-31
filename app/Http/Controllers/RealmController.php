<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class RealmController extends Controller
{
    public function updateRealms() {
        $requestUrl = "https://us.api.battle.net/wow/realm/status?locale=en_US&apikey=".env('BLIZZ_KEY');

        $client = new Client();

        try
        {
            $res = $client->request('GET', $requestUrl);

            return json_decode($res->getBody());
        }
        catch (RequestException $exception)
        {
            if($exception->hasResponse()) {
                echo Psr7\str($exception->getResponse());
            }
        }
    }
}
