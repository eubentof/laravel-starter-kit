<?php

namespace App\Actions\Users\DeleteUser;

use App\Models\User;
use App\Support\Actions\ActionExecutionException;
use App\Support\Actions\ActionHandler;

final class DeleteUserHandler extends ActionHandler
{
    public function __invoke(User $executor, DeleteUser $action): mixed
    {
        if (! $executor->canDeleteOwnAccount()) {
            throw ActionExecutionException::forbidden();
        }

        return $executor->delete();
    }
}
