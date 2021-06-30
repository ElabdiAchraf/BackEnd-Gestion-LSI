<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Seance;
use Illuminate\Auth\Access\HandlesAuthorization;

class SeancePolicy
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
    public function create(User $user)
    {
        if ($user->permission == 2)
            return true;
        else
            return false;
    }
    public function update(User $user)
    {
        if ($user->permission == 2)
            return true;
        else
            return false;
    }
    public function delete(User $user)
    {
        if ($user->permission == 2)
            return true;
        else
            return false;
    }
}
