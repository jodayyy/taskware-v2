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

                <x-ui.error-list :errors="$errors" />

                <form method="POST" action="{{ route('profile.update') }}" class="profile-form" id="profileForm">
                    @csrf
                    @method('PUT')

                    <x-ui.form-input 
                        name="username" 
                        label="Username" 
                        :value="old('username', $user->username)"
                        minlength="3"
                        required
                        :readonly="!isset($editMode) || !$editMode"
                    />

                    <x-ui.form-input 
                        name="email" 
                        label="Email" 
                        type="email"
                        :value="old('email', $user->email)"
                        required
                        :readonly="!isset($editMode) || !$editMode"
                        class="mt-2"
                    />

                    <x-ui.form-input 
                        name="password" 
                        label="Password" 
                        type="password"
                        :placeholder="(!isset($editMode) || !$editMode) ? 'Leave blank to keep current password' : 'Enter new password (optional)'"
                        minlength="8"
                        :readonly="!isset($editMode) || !$editMode"
                        class="mt-2"
                    >
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
                    </x-ui.form-input>


                    <div class="profile-actions {{ isset($editMode) && $editMode ? 'visible' : '' }}" id="profileActions">
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
    
    document.getElementById('profileActions').classList.add('visible');
    const editButton = document.querySelector('.profile-header button');
    if (editButton) {
        editButton.style.display = 'none';
    }
    
    // Initialize password validation
    if (window.passwordValidation) {
        window.passwordValidation.initializePasswordValidation('password');
    }
}

function cancelEdit() {
    window.location.reload();
}

// Make functions globally available
window.enableEditMode = enableEditMode;
window.cancelEdit = cancelEdit;

document.addEventListener('DOMContentLoaded', function() {
    // If page loads in edit mode, initialize validation
    const passwordInput = document.getElementById('password');
    if (passwordInput && !passwordInput.hasAttribute('readonly') && window.passwordValidation) {
        window.passwordValidation.initializePasswordValidation('password');
    }
});
</script>
@endsection