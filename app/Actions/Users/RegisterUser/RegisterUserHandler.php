<?php

namespace App\Actions\Users\RegisterUser;

use App\Models\User;
use App\Support\Actions\GuestActionHandler;

final class RegisterUserHandler extends GuestActionHandler
{
    public function __invoke(RegisterUser $action): User
    {
        return User::create([
            'name' => $action->name,
            'email' => $action->email,
            'password' => $action->password,
        ]);
    }
}
