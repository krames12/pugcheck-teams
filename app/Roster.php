<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Character;
use App\Realm;

class Roster extends Model
{
    protected $fillable = ['name', 'realm', 'faction', 'owner_id'];

    public function characters()
    {
        return $this->belongsToMany(Character::class, 'roster_characters');
    }

    public function realmName()
    {
        $realm = Realm::where('id', $this->realm)->first();
        return $realm->name;
    }
}
