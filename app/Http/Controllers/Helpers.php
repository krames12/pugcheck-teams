<?php

namespace App\Http\Controllers;

class Helpers extends Controller
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
}
