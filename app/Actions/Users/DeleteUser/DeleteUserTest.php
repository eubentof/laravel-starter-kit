<?php

use App\Actions\Users\DeleteUser\DeleteUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

test('a user should be able to delete their account', function (): void {
    /** @Given a user is signed in */
    $user = User::factory()->create();
    Auth::login($user);

    /** @When they confirm account deletion with their password */
    DeleteUser::fromArray(['password' => 'password'])->execute($user);

    /** @Then their account is deleted */
    expect($user->fresh())->toBeNull();
});

test('an account should not be deleted with an incorrect password', function (): void {
    /** @Given a user is signed in */
    $user = User::factory()->create();
    Auth::login($user);

    /** @When they confirm account deletion with an incorrect password */
    $deleteAccount = fn () => DeleteUser::fromArray(['password' => 'incorrect'])->execute($user);

    /** @Then their account remains available */
    expect($deleteAccount)->toThrow(ValidationException::class);
    expect($user->fresh())->not->toBeNull();
});
