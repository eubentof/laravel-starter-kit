<?php

namespace App\Fortify;

use App\Actions\Users\RegisterUser\RegisterUser;
use App\Models\User;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        return RegisterUser::fromArray($input)->executeAsGuest();
    }
}
