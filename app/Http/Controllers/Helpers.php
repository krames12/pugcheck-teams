<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Lookups;

class Helpers extends Controller
{
    public static function isItemEnchanted($item, $classId, $classSpec)
    {
        /** Things that lead to `true`
         * spell_id == 0
         * item_slot not an offhand
         * If class + spec needs enchant
         */

        $meleeClasses = array(1, 4, 6, 7, 10, 12);
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
        $needsEnchant = false;

        if($item->item_slot == "offHand") {
            if(isset($meleeClasses[$classId]) && isset($meleeOffHandSpecs[$classSpec])) {
                $needsEnchant = $item->enchant->spell_id == 0 ? false : true;
            } else {
                $needsEnchant = true;
            }
        } else {
            $needsEnchant = $item->enchant->spell_id == 0 ? false : true;
        }

        return $needsEnchant;
    }
}
