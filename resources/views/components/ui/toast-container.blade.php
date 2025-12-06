{{-- Toast Container for Flash Messages --}}
@if(session('success'))
    <div data-toast-success="{{ session('success') }}" style="display: none;"></div>
@endif

@if(session('error'))
    <div data-toast-error="{{ session('error') }}" style="display: none;"></div>
@endif

@if(session('info'))
    <div data-toast-info="{{ session('info') }}" style="display: none;"></div>
@endif

@if(isset($errors) && $errors->any())
    @php
        $errorContext = 'Validation failed';
        
        // Check old input to determine which form was submitted
        $oldMethod = old('_method');
        $hasCurrentPassword = old('current_password') !== null;
        $hasUsername = old('username') !== null;
        $hasEmail = old('email') !== null;
        $currentPath = request()->path();
        
        // Check for password change form (has current_password field OR is on change-password page)
        if ($hasCurrentPassword || $currentPath === 'profile/change-password') {
            $errorContext = 'Password change failed';
        }
        // Check for profile update form (has username/email but not current_password, and PUT method)
        elseif (($hasUsername || $hasEmail) && !$hasCurrentPassword && $oldMethod === 'PUT') {
            $errorContext = 'Profile update failed';
        }
        // Check route name and path as fallback
        else {
            $routeName = request()->route() ? request()->route()->getName() : null;
            
            if ($routeName === 'login' || $currentPath === 'login') {
                $errorContext = 'Login failed';
            } elseif ($routeName === 'register' || $currentPath === 'register') {
                $errorContext = 'User registration failed';
            } elseif ($currentPath === 'profile' && $oldMethod === 'PUT' && !$hasCurrentPassword) {
                $errorContext = 'Profile update failed';
            } elseif ($currentPath === 'profile/change-password') {
                $errorContext = 'Password change failed';
            }
        }
    @endphp
    <div data-toast-error="{{ $errorContext }}" style="display: none;"></div>
@endif

