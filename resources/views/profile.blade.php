@extends('layouts.app')

@section('title', 'Profile')

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
                    <h1 class="dashboard-title">Profile</h1>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="profile-header-actions" id="profileHeaderActions">
                        @if(!isset($editMode) || !$editMode)
                            <button type="button" class="btn btn-primary" onclick="enableEditMode()">Edit Profile</button>
                            <a href="{{ route('profile.password.show') }}" class="btn btn-primary">Change Password</a>
                        @endif
                    </div>
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

                    <div class="profile-actions {{ isset($editMode) && $editMode ? 'visible' : '' }}" id="profileActions">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
                    </div>
                </form>
            </div>
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
    
    document.getElementById('profileActions').classList.add('visible');
    const headerActions = document.getElementById('profileHeaderActions');
    if (headerActions) {
        headerActions.style.display = 'none';
    }
}

function cancelEdit() {
    window.location.reload();
}

// Make functions globally available
window.enableEditMode = enableEditMode;
window.cancelEdit = cancelEdit;

</script>
@endsection