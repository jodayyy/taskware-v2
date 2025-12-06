<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(): View
    {
        $user = Auth::user();
        
        return view('profile', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile.
     */
    public function update(ProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();
        
        $updateData = [
            'username' => $request->username,
            'email' => $request->email,
        ];
        
        $user->update($updateData);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    /**
     * Show the change password form.
     */
    public function showChangePassword(): View
    {
        return view('change-password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(ChangePasswordRequest $request): RedirectResponse
    {
        $user = Auth::user();
        
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.show')->with('success', 'Password changed successfully!');
    }
}