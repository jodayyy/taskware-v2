<?php

declare(strict_types=1);

namespace App\Http\Controllers;

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
        
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }
        
        $user->update($updateData);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }
}