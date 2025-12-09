@extends('layouts.app')

@section('title', 'Profile - Change Password')

@section('content')
<x-layout.page>
    <x-layout.container>
        <div class="profile-header">
            <h1 class="main-content-title">Change Password</h1>
        </div>

        <form method="POST" action="{{ route('profile.password.update') }}" class="profile-form" id="changePasswordForm">
            @csrf
            @method('PUT')

            <x-ui.form-input 
                name="current_password" 
                label="Current Password" 
                type="password"
                required
                autofocus
            />

            <x-ui.form-input 
                name="password" 
                label="New Password" 
                type="password"
                minlength="8"
                required
                class="mt-2"
            >
                <x-ui.password-requirements />
            </x-ui.form-input>

            <x-ui.form-input 
                name="password_confirmation" 
                label="Confirm New Password" 
                type="password"
                required
                class="mt-2"
            >
                <div id="password-match" class="password-match"></div>
            </x-ui.form-input>

            <div class="profile-actions visible">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('profile.show') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </x-layout.container>
</x-layout.page>
@endsection

