/**
 * Password Form Initialization
 * Initializes password validation for forms with password fields
 */

export function initializePasswordForm(passwordInputId = 'password', confirmInputId = 'password_confirmation', matchIndicatorId = 'password-match') {
    if (window.passwordValidation) {
        window.passwordValidation.initializePasswordValidation(passwordInputId);
        window.passwordValidation.initializePasswordMatch(passwordInputId, confirmInputId, matchIndicatorId);
    }
}

// Auto-initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    // Check if password form exists
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    
    if (passwordInput && confirmInput) {
        initializePasswordForm();
    }
});

