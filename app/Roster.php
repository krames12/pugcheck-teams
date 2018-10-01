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
        return $this->belongsToMany(Character::class, 'roster_characters')->withPivot(['main_spec', 'off_spec'])->withTimeStamps();
    }

    public function realm()
    {
        return $this->belongsTo(Realm::class);
    }

    public function tanks()
    {
        return $this->belongsToMany(Character::class, 'roster_characters')
            ->withPivot(['main_spec', 'off_spec'])
            ->where('main_spec', '=', 'tank')
            ->orWhere('off_spec', '=', 'tank');
    }

    public function healers()
    {
        return $this->belongsToMany(Character::class, 'roster_characters')
            ->withPivot(['main_spec', 'off_spec'])
            ->where('main_spec', '=', 'healer')
            ->orWhere('off_spec', '=', 'healer')
            ->orderBy('main_spec');
    }

    public function meleeDps()
    {
        return $this->belongsToMany(Character::class, 'roster_characters')
            ->withPivot(['main_spec', 'off_spec'])
            ->where('main_spec', '=', 'mdps')
            ->orWhere('off_spec', '=', 'mdps');
    }

    public function rangedDps()
    {
        return $this->belongsToMany(Character::class, 'roster_characters')
            ->withPivot(['main_spec', 'off_spec'])
            ->where('main_spec', '=', 'rdps')
            ->orWhere('off_spec', '=', 'rdps');
    }
}
