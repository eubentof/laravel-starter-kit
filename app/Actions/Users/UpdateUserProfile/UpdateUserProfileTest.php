<?php

use App\Actions\Users\UpdateUserProfile\UpdateUserProfile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

test('a user should be able to update their profile', function (): void {
    /** @Given a user is signed in */
    $user = User::factory()->create();
    Auth::login($user);

    /** @When they change their name or email address */
    UpdateUserProfile::fromArray(['name' => 'Changed', 'email' => $user->email])->execute($user);

    /** @Then their profile contains the new details */
    expect($user->refresh()->name)->toBe('Changed');
});

test('changing an email address should require verification again', function (): void {
    /** @Given a user has a verified email address */
    $user = User::factory()->create();
    Auth::login($user);

    /** @When they change their email address */
    UpdateUserProfile::fromArray(['name' => $user->name, 'email' => 'changed@example.test'])->execute($user);

    /** @Then the new email address is unverified */
    expect($user->refresh()->email_verified_at)->toBeNull();
});
