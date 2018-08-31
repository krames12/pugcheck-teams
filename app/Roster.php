<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Character;

class Roster extends Model
{
    protected $fillable = ['name', 'realm', 'faction', 'owner_id'];

    public function characters()
    {
        return $this->belongsToMany(Character::class, 'roster_characters');
    }
}
