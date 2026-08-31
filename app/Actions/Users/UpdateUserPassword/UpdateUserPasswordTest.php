<?php

use App\Actions\Users\UpdateUserPassword\UpdateUserPassword;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

test('a user should be able to update their password', function (): void {
    /** @Given a user knows their current password */
    $user = User::factory()->create();
    Auth::login($user);

    /** @When they provide a confirmed new password */
    UpdateUserPassword::fromArray([
        'current_password' => 'password',
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ])->execute($user);

    /** @Then they can use the new password to sign in */
    expect(Hash::check('new-password', $user->refresh()->password))->toBeTrue();
});

test('a user should provide their current password', function (): void {
    /** @Given a user is signed in */
    $user = User::factory()->create();
    Auth::login($user);

    /** @When they provide an incorrect current password */
    $updatePassword = fn () => UpdateUserPassword::fromArray([
        'current_password' => 'incorrect',
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ])->execute($user);

    /** @Then their password is not changed */
    expect($updatePassword)->toThrow(ValidationException::class);
});
