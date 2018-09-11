<?php

namespace App\Policies;

use App\User;
use App\Roster;

use Illuminate\Auth\Access\HandlesAuthorization;
use phpDocumentor\Reflection\Types\Boolean;

class RosterPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Update rosters
     *
     * @param \App\User $user
     * * @param \App\Roster $roster
     * @return bool
     */
    public function update(?User $user, Roster $roster)
    {
        return $user->id === $roster->user_id;
    }
}
