<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

use App\Realm;

class RealmController extends Controller
{
    public function updateRealms() {
        $requestUrl = "https://us.api.battle.net/wow/realm/status?locale=en_US&apikey=".env('BLIZZ_KEY');

        $client = new Client();

        try
        {
            $res = $client->request('GET', $requestUrl);

            $realms = json_decode($res->getBody());

            foreach($realms->realms as $realm)
            {
                $realmExists = Realm::where([['name', '=', $realm->name], ['slug', '=', $realm->slug]])->first();

                if($realmExists === null) {
                    $newRealm = new Realm();
                    $newRealm->name = $realm->name;
                    $newRealm->slug = $realm->slug;
                    $newRealm->region = 'us';

                    $newRealm->save();
                }
            }

            redirect('/');
        }
        catch (RequestException $exception)
        {
            if($exception->hasResponse()) {
                echo Psr7\str($exception->getResponse());
            }
        }
    }
}
