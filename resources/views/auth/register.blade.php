@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">Register</h1>

        <x-ui.error-list :errors="$errors" />

        <form method="POST" action="{{ route('register') }}" class="auth-form" id="registerForm">
            @csrf

            <x-ui.form-input 
                name="username" 
                label="Username" 
                :value="old('username')"
                minlength="3"
                required 
                autofocus
            />

            <x-ui.form-input 
                name="email" 
                label="Email" 
                type="email"
                :value="old('email')"
                required
            />

            <x-ui.form-input 
                name="password" 
                label="Password" 
                type="password"
                minlength="8"
                required
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
                label="Confirm Password" 
                type="password"
                required
            >
                <div id="password-match" class="password-match"></div>
            </x-ui.form-input>

            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>

        <div class="auth-footer">
            <p>Already have an account? <a href="{{ route('login') }}" class="auth-link">Login here</a></p>
        </div>
    </div>
</div>
@endsection