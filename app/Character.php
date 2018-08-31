<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Character extends Model
{
    public function gear()
    {
        return $this->hasMany('\App\CharacterGear');
    }
}
