<?php

namespace App\Fortify;

use App\Actions\Users\ResetUserPassword\ResetUserPassword as ResetUserPasswordAction;
use App\Models\User;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class ResetUserPassword implements ResetsUserPasswords
{
    /**
     * Validate and reset the user's forgotten password.
     *
     * @param  array<string, string>  $input
     */
    public function reset(User $user, array $input): void
    {
        ResetUserPasswordAction::fromArray($input)->execute($user);
    }
}
