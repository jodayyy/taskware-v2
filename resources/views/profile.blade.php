@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="main-layout">
    <x-layout.sidebar />
    
    <div class="main-content-wrapper">
        <x-layout.topbar />
        
        <div class="dashboard-container">
            <div class="dashboard-content">
                <div class="profile-header">
                    <h1 class="dashboard-title">Profile</h1>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(!isset($editMode) || !$editMode)
                        <button type="button" class="btn btn-primary" onclick="enableEditMode()">Edit</button>
                    @endif
                </div>

                @if ($errors->any())
                    <div class="auth-error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" class="profile-form" id="profileForm">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            class="form-input @error('username') form-input-error @enderror" 
                            value="{{ old('username', $user->username) }}" 
                            required 
                            minlength="3"
                            {{ !isset($editMode) || !$editMode ? 'readonly' : '' }}
                        >
                        @error('username')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mt-2">
                        <label for="email" class="form-label">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input @error('email') form-input-error @enderror" 
                            value="{{ old('email', $user->email) }}" 
                            required
                            {{ !isset($editMode) || !$editMode ? 'readonly' : '' }}
                        >
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mt-2">
                        <label for="password" class="form-label">Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input @error('password') form-input-error @enderror" 
                            placeholder="{{ !isset($editMode) || !$editMode ? 'Leave blank to keep current password' : 'Enter new password (optional)' }}"
                            minlength="8"
                            {{ !isset($editMode) || !$editMode ? 'readonly' : '' }}
                        >
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                        
                        @if(isset($editMode) && $editMode)
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
                        @endif
                    </div>


                    <div class="profile-actions" id="profileActions" style="display: {{ isset($editMode) && $editMode ? 'flex' : 'none' }};">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function enableEditMode() {
    const inputs = document.querySelectorAll('#profileForm input[readonly]');
    inputs.forEach(input => {
        input.removeAttribute('readonly');
    });
    
    const passwordInput = document.getElementById('password');
    passwordInput.placeholder = 'Enter new password (optional)';
    
    const passwordRequirements = document.querySelector('.password-requirements');
    if (!passwordRequirements) {
        const passwordGroup = passwordInput.closest('.form-group');
        const requirementsHTML = `
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
        `;
        passwordGroup.insertAdjacentHTML('beforeend', requirementsHTML);
    }
    
    document.getElementById('profileActions').style.display = 'flex';
    document.querySelector('.profile-header button').style.display = 'none';
    
    // Initialize password validation
    initializePasswordValidation();
}

function cancelEdit() {
    window.location.reload();
}

function checkPasswordRequirements(password) {
    const requirements = {
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        number: /[0-9]/.test(password),
        special: /[^A-Za-z0-9]/.test(password),
        length: password.length >= 8
    };

    // Update requirement indicators
    const reqUppercase = document.getElementById('req-uppercase');
    const reqLowercase = document.getElementById('req-lowercase');
    const reqNumber = document.getElementById('req-number');
    const reqSpecial = document.getElementById('req-special');
    const reqLength = document.getElementById('req-length');
    
    if (reqUppercase) reqUppercase.classList.toggle('requirement-met', requirements.uppercase);
    if (reqLowercase) reqLowercase.classList.toggle('requirement-met', requirements.lowercase);
    if (reqNumber) reqNumber.classList.toggle('requirement-met', requirements.number);
    if (reqSpecial) reqSpecial.classList.toggle('requirement-met', requirements.special);
    if (reqLength) reqLength.classList.toggle('requirement-met', requirements.length);

    return Object.values(requirements).every(req => req === true);
}

function initializePasswordValidation() {
    const passwordInput = document.getElementById('password');
    
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                checkPasswordRequirements(this.value);
            } else {
                // Reset all requirements if password is empty
                ['req-uppercase', 'req-lowercase', 'req-number', 'req-special', 'req-length'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.classList.remove('requirement-met');
                });
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // If page loads in edit mode, initialize validation
    const passwordInput = document.getElementById('password');
    if (passwordInput && !passwordInput.hasAttribute('readonly')) {
        initializePasswordValidation();
    }
});
</script>
@endsection