<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemProperties extends Model
{
    //
    public function character_gear()
    {
        return $this->belongsTo(CharacterGear::class);
    }
}
