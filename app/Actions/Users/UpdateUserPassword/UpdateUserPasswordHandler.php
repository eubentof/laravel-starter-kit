<?php

namespace App\Actions\Users\UpdateUserPassword;

use App\Models\User;
use App\Support\Actions\ActionExecutionException;
use App\Support\Actions\ActionHandler;

final class UpdateUserPasswordHandler extends ActionHandler
{
    public function __invoke(User $executor, UpdateUserPassword $action): User
    {
        if (! $executor->canUpdateOwnPassword()) {
            throw ActionExecutionException::forbidden();
        }

        $executor->update(['password' => $action->password]);

        return $executor;
    }
}
