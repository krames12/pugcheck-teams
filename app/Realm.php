<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Roster;

class Realm extends Model
{
    public function rosters()
    {
        return $this->hasMany(Roster::class);
    }
}
