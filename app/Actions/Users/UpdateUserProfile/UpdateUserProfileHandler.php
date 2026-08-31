<?php

namespace App\Actions\Users\UpdateUserProfile;

use App\Models\User;
use App\Support\Actions\ActionExecutionException;
use App\Support\Actions\ActionHandler;

final class UpdateUserProfileHandler extends ActionHandler
{
    public function __invoke(User $executor, UpdateUserProfile $action): User
    {
        if (! $executor->canUpdateOwnProfile()) {
            throw ActionExecutionException::forbidden();
        }

        $executor->fill(['name' => $action->name, 'email' => $action->email]);

        if ($executor->isDirty('email')) {
            $executor->email_verified_at = null;
        }

        $executor->save();

        return $executor;
    }
}
