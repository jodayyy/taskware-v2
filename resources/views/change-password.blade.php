@extends('layouts.app')

@section('title', 'Profile - Change Password')

@section('content')
<div class="main-layout">
    <x-layout.topbar />
    
    <div class="main-content-wrapper">
        <div class="sidebar-container">
            <x-layout.sidebar />
        </div>
        
        <div class="main-content-area">
            <div class="dashboard-container">
            <div class="dashboard-content">
                <div class="profile-header">
                    <h1 class="dashboard-title">Profile - Change Password</h1>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>

                <x-ui.error-list :errors="$errors" />

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
                        <div class="password-requirements">
                            <p class="password-requirements-title">Password must contain:</p>
                            <ul class="password-requirements-list">
                                <li id="req-uppercase" class="password-requirement">
                                    <span class="requirement-icon">✗</span>
                                    <span>At least one uppercase letter</span>
                                </li>
                                <li id="req-lowercase" class="password-requirement">
                                    <span class="requirement-icon">✗</span>
                                    <span>At least one lowercase letter</span>
                                </li>
                                <li id="req-number" class="password-requirement">
                                    <span class="requirement-icon">✗</span>
                                    <span>At least one number</span>
                                </li>
                                <li id="req-special" class="password-requirement">
                                    <span class="requirement-icon">✗</span>
                                    <span>At least one special character</span>
                                </li>
                                <li id="req-length" class="password-requirement">
                                    <span class="requirement-icon">✗</span>
                                    <span>At least 8 characters</span>
                                </li>
                            </ul>
                        </div>
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
            </div>
        </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize password validation
    if (window.passwordValidation) {
        window.passwordValidation.initializePasswordValidation('password');
        window.passwordValidation.initializePasswordMatch('password', 'password_confirmation', 'password-match');
    }
});
</script>
@endsection

