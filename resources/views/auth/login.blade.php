@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">Login</h1>

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            <x-ui.form-input 
                name="username" 
                label="Username" 
                :value="old('username')"
                required 
                autofocus
            />

            <x-ui.form-input 
                name="password" 
                label="Password" 
                type="password"
                required
            />

            <div class="form-group">
                <label class="form-checkbox">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>Remember me</span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>

        <div class="auth-footer">
            <p>Don't have an account? <a href="{{ route('register') }}" class="auth-link">Register here</a></p>
        </div>
    </div>
</div>
@endsection