/**
 * Password Toggle Functionality
 * Adds show/hide password functionality to all password fields
 */

document.addEventListener('DOMContentLoaded', function() {
    // Find all password toggle buttons
    const passwordToggleButtons = document.querySelectorAll('.password-toggle-btn');
    
    passwordToggleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Find the associated password input
            const passwordWrapper = this.closest('.password-input-wrapper');
            if (!passwordWrapper) return;
            
            const passwordInput = passwordWrapper.querySelector('.password-input');
            if (!passwordInput) return;
            
            // Find the eye icon containers
            const eyeOpenIcon = this.querySelector('.eye-open-icon');
            const eyeClosedIcon = this.querySelector('.eye-closed-icon');
            
            // Toggle password visibility
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                // Show closed eye, hide open eye
                if (eyeOpenIcon) eyeOpenIcon.classList.add('hidden');
                if (eyeClosedIcon) eyeClosedIcon.classList.remove('hidden');
                this.setAttribute('aria-label', 'Hide password');
            } else {
                passwordInput.type = 'password';
                // Show open eye, hide closed eye
                if (eyeOpenIcon) eyeOpenIcon.classList.remove('hidden');
                if (eyeClosedIcon) eyeClosedIcon.classList.add('hidden');
                this.setAttribute('aria-label', 'Show password');
            }
        });
    });
});

