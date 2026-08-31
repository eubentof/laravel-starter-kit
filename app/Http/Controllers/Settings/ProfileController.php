<?php

namespace App\Http\Controllers\Settings;

use App\Actions\Users\DeleteUser\DeleteUser;
use App\Actions\Users\UpdateUserProfile\UpdateUserProfile;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('settings/Profile', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        UpdateUserProfile::fromArray($request->only(['name', 'email']))->execute($request->user());

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Profile updated.')]);

        return to_route('profile.edit');
    }

    /**
     * Delete the user's profile.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        DeleteUser::fromArray($request->only('password'))->execute($user);

        // The account no longer exists, so avoid cycling and persisting a remember token.
        Auth::logoutCurrentDevice();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
