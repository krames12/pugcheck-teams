<?php

namespace App\Http\Controllers;

use App\Http\BlizzardOAuth2;
use Illuminate\Http\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class Lookups extends Controller
{
    // Class lookup based on Blizzard class id
    public static function classLookup($classId) {
        switch($classId) {
            case 1:
                return 'warrior';
                break;
            case 2:
                return 'paladin';
                break;
            case 3:
                return 'hunter';
                break;
            case 4:
                return 'rogue';
                break;
            case 5:
                return 'priest';
                break;
            case 6:
                return 'death-knight';
                break;
            case 7:
                return 'shaman';
                break;
            case 8:
                return 'mage';
                break;
            case 9:
                return 'warlock';
                break;
            case 10:
                return 'monk';
                break;
            case 11:
                return 'druid';
                break;
            case 12:
                return 'demon-hunter';
                break;
        }
    }

    public static function itemSlotNumber($slotNumber)
    {
        switch($slotNumber) {
            case('1'):
                return "head";
                break;
            case('2'):
                return "neck";
                break;
            case('3'):
                return "shoulder";
                break;
            case('5'):
                return "chest";
                break;
            case('6'):
                return "waist";
                break;
            case('7'):
                return "legs";
                break;
            case('8'):
                return "feet";
                break;
            case('9'):
                return "wrist";
                break;
            case('10'):
                return "hands";
                break;
            case('11'):
                return "finger1";
                break;
            case('12'):
                return "finger2";
                break;
            case('13'):
                return "trinket1";
                break;
            case('14'):
                return "trinket2";
                break;
            case('15'):
                return "mainHand";
                break;
            case('16'):
                return "offHand";
                break;
        }
    }

    public static function apiCharacter($authToken, $characterName, $realmSlug)
    {
        $requestUrl = "https://us.api.blizzard.com/wow/character/$realmSlug/$characterName?fields=items,talents,audit&locale=en_US";

        $client = new Client([
            'handler' => $authToken,
            'auth' => 'oauth',
        ]);
        try {
            $res = $client->request('GET', $requestUrl);
            return json_decode($res->getBody());
        } catch (RequestException $e) {
            if($e->hasResponse()) {
                return back()->with('error', $e->getResponse()->getReasonPhrase());
            }
        }
    }
}
