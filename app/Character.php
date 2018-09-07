<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\CharacterGear;
use App\Realm;
use App\Roster;
use App\RosterCharacter;

class Character extends Model
{
    public function gear()
    {
        return $this->hasMany(CharacterGear::class);
    }

    public function rosters()
    {
        return $this->belongsToMany(Roster::class, 'roster_characters')->withPivot('main_spec', 'off_spec');
    }

    public function realmName()
    {
        $realm = Realm::where('id', $this->realm)->first();
        return $realm->name;
    }
}
