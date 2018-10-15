<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemProperties extends Model
{
    protected $table = 'item_properties';
    //
    public function character_gear()
    {
        return $this->belongsTo(CharacterGear::class);
    }
}
