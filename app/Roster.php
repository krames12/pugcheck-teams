<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    protected $fillable = ['name', 'realm', 'faction', 'owner_id'];
}
