<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile with edit mode if validation failed.
     */
    public function show(): View
    {
        $editMode = old('_method') === 'PUT' || request()->has('edit');
        
        return view('profile', [
            'user' => auth()->user(),
            'editMode' => $editMode,
        ]);
    }

    /**
     * Update the user's profile.
     */
    public function update(ProfileRequest $request): RedirectResponse
    {
        $data = $request->only(['username', 'email']);
        $data['notify_on_project_created'] = $request->has('notify_on_project_created');
        
        auth()->user()->update($data);

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
        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.show')->with('success', 'Password changed successfully!');
    }
}