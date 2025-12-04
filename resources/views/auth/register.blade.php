@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">Register</h1>

        @if ($errors->any())
            <div class="auth-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="auth-form" id="registerForm">
            @csrf

            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    class="form-input @error('username') form-input-error @enderror" 
                    value="{{ old('username') }}" 
                    required 
                    autofocus
                    minlength="3"
                >
                @error('username')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-input @error('email') form-input-error @enderror" 
                    value="{{ old('email') }}" 
                    required
                >
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-input @error('password') form-input-error @enderror" 
                    required
                    minlength="8"
                >
                @error('password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
                
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
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="form-input @error('password_confirmation') form-input-error @enderror" 
                    required
                >
                @error('password_confirmation')
                    <span class="form-error">{{ $message }}</span>
                @enderror
                <div id="password-match" class="password-match"></div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>

        <div class="auth-footer">
            <p>Already have an account? <a href="{{ route('login') }}" class="auth-link">Login here</a></p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    const passwordMatch = document.getElementById('password-match');

    function checkPasswordRequirements(password) {
        const requirements = {
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[^A-Za-z0-9]/.test(password),
            length: password.length >= 8
        };

        // Update requirement indicators
        document.getElementById('req-uppercase').classList.toggle('requirement-met', requirements.uppercase);
        document.getElementById('req-lowercase').classList.toggle('requirement-met', requirements.lowercase);
        document.getElementById('req-number').classList.toggle('requirement-met', requirements.number);
        document.getElementById('req-special').classList.toggle('requirement-met', requirements.special);
        document.getElementById('req-length').classList.toggle('requirement-met', requirements.length);

        return Object.values(requirements).every(req => req === true);
    }

    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (confirmPassword.length === 0) {
            passwordMatch.textContent = '';
            passwordMatch.className = 'password-match';
            return;
        }

        if (password === confirmPassword) {
            passwordMatch.textContent = '✓ Passwords match';
            passwordMatch.className = 'password-match password-match-success';
        } else {
            passwordMatch.textContent = '✗ Passwords do not match';
            passwordMatch.className = 'password-match password-match-error';
        }
    }

    passwordInput.addEventListener('input', function() {
        checkPasswordRequirements(this.value);
        checkPasswordMatch();
    });

    confirmPasswordInput.addEventListener('input', checkPasswordMatch);
});
</script>
@endsection



