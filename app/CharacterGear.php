<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharacterGear extends Model
{
    protected $table = 'character_gear';

    public function item_properties()
    {
        return $this->hasMany(ItemProperties::class);
    }
}
