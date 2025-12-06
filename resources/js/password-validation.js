/**
 * Password Validation Utility
 * Shared password validation logic for registration and profile forms
 */

const requirementConfig = [
    { key: 'uppercase', pattern: /[A-Z]/, id: 'req-uppercase' },
    { key: 'lowercase', pattern: /[a-z]/, id: 'req-lowercase' },
    { key: 'number', pattern: /[0-9]/, id: 'req-number' },
    { key: 'special', pattern: /[^A-Za-z0-9]/, id: 'req-special' },
    { key: 'length', pattern: null, id: 'req-length', check: (pwd) => pwd.length >= 8 }
];

export function checkPasswordRequirements(password) {
    const requirements = {};
    
    requirementConfig.forEach(({ key, pattern, check }) => {
        requirements[key] = check ? check(password) : pattern.test(password);
    });

    // Update requirement indicators
    requirementConfig.forEach(({ id, key }) => {
        const element = document.getElementById(id);
        if (element) {
            element.classList.toggle('requirement-met', requirements[key]);
        }
    });

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
                requirementConfig.forEach(({ id }) => {
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

    const isMatch = password === confirmPassword;
    passwordMatch.textContent = isMatch ? '✓ Passwords match' : '✗ Passwords do not match';
    passwordMatch.className = `password-match ${isMatch ? 'password-match-success' : 'password-match-error'}`;
}

export function initializePasswordMatch(passwordInputId, confirmPasswordInputId, matchIndicatorId) {
    const passwordInput = document.getElementById(passwordInputId);
    const confirmPasswordInput = document.getElementById(confirmPasswordInputId);

    if (passwordInput && confirmPasswordInput) {
        const updateMatch = () => checkPasswordMatch(passwordInputId, confirmPasswordInputId, matchIndicatorId);
        passwordInput.addEventListener('input', updateMatch);
        confirmPasswordInput.addEventListener('input', updateMatch);
    }
}

