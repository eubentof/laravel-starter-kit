<?php

use App\Actions\Users\ResetUserPassword\ResetUserPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

test('a user should be able to choose a new password', function (): void {
    /** @Given a user has a valid password reset request */
    $user = User::factory()->create();

    /** @When they provide a confirmed new password */
    ResetUserPassword::fromArray([
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ])->execute($user);

    /** @Then they can use the new password to sign in */
    expect(Hash::check('new-password', $user->refresh()->password))->toBeTrue();
});

test('a password reset should require matching confirmation', function (): void {
    /** @Given a user has a valid password reset request */
    $user = User::factory()->create();

    /** @When their password confirmation does not match */
    $resetPassword = fn () => ResetUserPassword::fromArray([
        'password' => 'new-password',
        'password_confirmation' => 'different-password',
    ])->execute($user);

    /** @Then their password is not changed */
    expect($resetPassword)->toThrow(ValidationException::class);
});
