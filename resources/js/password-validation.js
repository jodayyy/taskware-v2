/**
 * Password Validation Utility
 * Shared password validation logic for registration and profile forms
 */

export function checkPasswordRequirements(password) {
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

export function initializePasswordValidation(passwordInputId) {
    const passwordInput = document.getElementById(passwordInputId);
    
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

export function checkPasswordMatch(passwordInputId, confirmPasswordInputId, matchIndicatorId) {
    const passwordInput = document.getElementById(passwordInputId);
    const confirmPasswordInput = document.getElementById(confirmPasswordInputId);
    const passwordMatch = document.getElementById(matchIndicatorId);

    if (!passwordInput || !confirmPasswordInput || !passwordMatch) {
        return;
    }

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

export function initializePasswordMatch(passwordInputId, confirmPasswordInputId, matchIndicatorId) {
    const passwordInput = document.getElementById(passwordInputId);
    const confirmPasswordInput = document.getElementById(confirmPasswordInputId);

    if (passwordInput && confirmPasswordInput) {
        const updateMatch = () => {
            checkPasswordMatch(passwordInputId, confirmPasswordInputId, matchIndicatorId);
        };

        passwordInput.addEventListener('input', updateMatch);
        confirmPasswordInput.addEventListener('input', updateMatch);
    }
}

