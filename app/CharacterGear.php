<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharacterGear extends Model
{
    protected $table = 'character_gear';

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function item_properties()
    {
        return $this->hasMany(ItemProperties::class);
    }

    public function enchant()
    {
        return $this->hasOne(ItemProperties::class)->where('property', 'enchant');
    }

    public function socket()
    {
        return $this->hasOne(ItemProperties::class)->where('property', 'socket');
    }
}
