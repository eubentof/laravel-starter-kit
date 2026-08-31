<?php

namespace App\Actions\Users\ResetUserPassword;

use App\Models\User;
use App\Support\Actions\ActionHandler;
use Illuminate\Support\Str;

final class ResetUserPasswordHandler extends ActionHandler
{
    public function __invoke(User $executor, ResetUserPassword $action): User
    {
        $executor->forceFill([
            'password' => $action->password,
            'remember_token' => Str::random(60),
        ])->save();

        return $executor;
    }
}
