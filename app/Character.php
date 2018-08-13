<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Character extends Model
{
    /**
     *  Create a new character
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $character = new Character;

        $character->user_id = $request->user_id;
        $character->name = $request->name;
        $character->class = $request->class;
        $character->race = $request->race;
        $character->item_level = $request->item_level;

        $character->save();
    }
}
