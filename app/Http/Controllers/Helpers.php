<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Lookups;

class Helpers extends Controller
{
    public static function shouldBeEnchanted($itemType, $classId, $classSpec)
    {
        $meleeOffHandSpecs = array(
            "Frost",
            "Havoc",
            "Vengeance",
            "Windwalker",
            "Assassination",
            "Outlaw",
            "Subtlety",
            "Enhancement",
            "Fury"
        );

        if($itemType != "offHand") {
            return true;
        } else if(in_array($classId, array(1, 4, 6, 7, 10, 12)) && in_array($classSpec, $meleeOffHandSpecs)) {
            return true;
        } else {
            return false;
        }
    }
}
