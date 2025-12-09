@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<x-layout.page>
                <div class="profile-header">
        <h1 class="main-content-title">{{ isset($editMode) && $editMode ? 'Edit Profile' : 'Profile' }}</h1>
                </div>

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

                    <div class="form-group mt-2">
                        <label class="form-checkbox" id="notifyCheckboxLabel" style="{{ !isset($editMode) || !$editMode ? 'pointer-events: none; opacity: 0.6;' : '' }}">
                            <input 
                                type="checkbox" 
                                name="notify_on_project_created" 
                                value="1"
                                id="notifyCheckbox"
                                {{ old('notify_on_project_created', $user->notify_on_project_created) ? 'checked' : '' }}
                                {{ !isset($editMode) || !$editMode ? 'disabled' : '' }}
                            >
                            <span>Notify me via email when a new project is created</span>
                        </label>
                    </div>

                    <div class="profile-actions {{ isset($editMode) && $editMode ? 'visible' : '' }}" id="profileActions">
                        <div class="profile-actions-left">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
                        </div>
                        <div class="profile-actions-right" style="display: {{ isset($editMode) && $editMode ? 'flex' : 'none' }};">
                            <button type="button" class="btn btn-danger" data-delete-dialog="deleteAccountDialog" data-delete-form="delete-account-form">Delete Account</button>
                        </div>
                    </div>
                </form>
                
                <form id="delete-account-form" method="POST" action="{{ route('profile.delete') }}" class="inline-form" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                
                <div class="profile-bottom-actions" id="profileBottomActions">
                    @if(!isset($editMode) || !$editMode)
                        <button type="button" class="btn btn-primary" onclick="enableEditMode()">Edit Profile</button>
                        <a href="{{ route('profile.password.show') }}" class="btn btn-primary">Change Password</a>
                    @endif
                </div>

    <x-ui.delete-confirm-dialog 
        id="deleteAccountDialog"
        title="Delete Account"
        message="Are you sure you want to delete your account? This action cannot be undone. All your data will be permanently deleted."
        confirm-text="Delete Account"
        cancel-text="Cancel"
    />
</x-layout.page>
@endsection