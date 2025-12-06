@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">Register</h1>

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
                <x-ui.password-requirements />
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