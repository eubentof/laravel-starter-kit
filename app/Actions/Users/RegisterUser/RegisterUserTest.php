<?php

use App\Actions\Users\RegisterUser\RegisterUser;
use App\Models\User;
use Illuminate\Validation\ValidationException;

test('a guest should be able to create an account', function (): void {
    /** @Given a guest provides valid account details */
    $details = [
        'name' => 'Starter User',
        'email' => 'USER@example.test',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    /** @When they register */
    $user = RegisterUser::fromArray($details)->executeAsGuest();

    /** @Then their account is created */
    expect($user)->toBeInstanceOf(User::class)
        ->and($user->email)->toBe('user@example.test');
});

test('an email address should belong to only one account', function (): void {
    /** @Given an account already uses an email address */
    User::factory()->create(['email' => 'user@example.test']);

    /** @When a guest registers with the same email address */
    $registerAccount = fn () => RegisterUser::fromArray([
        'name' => 'Another User',
        'email' => 'user@example.test',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->executeAsGuest();

    /** @Then the new account is not created */
    expect($registerAccount)->toThrow(ValidationException::class);
});
