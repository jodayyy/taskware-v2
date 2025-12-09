/**
 * Profile Edit Mode Functionality
 */

export function enableEditMode() {
    const inputs = document.querySelectorAll('#profileForm input[readonly]');
    inputs.forEach(input => {
        input.removeAttribute('readonly');
    });
    
    // Enable checkbox
    const checkbox = document.querySelector('#profileForm input[type="checkbox"][name="notify_on_project_created"]');
    if (checkbox) {
        checkbox.removeAttribute('disabled');
    }
    
    // Remove disabled styling from checkbox label
    const checkboxLabel = checkbox?.closest('.form-checkbox');
    if (checkboxLabel) {
        checkboxLabel.style.pointerEvents = '';
        checkboxLabel.style.opacity = '';
    }
    
    document.getElementById('profileActions').classList.add('visible');
    const bottomActions = document.getElementById('profileBottomActions');
    if (bottomActions) {
        bottomActions.style.display = 'none';
    }
    
    // Show delete account button
    const deleteAccountDiv = document.querySelector('.profile-actions-right');
    if (deleteAccountDiv) {
        deleteAccountDiv.style.display = 'flex';
    }
    
    // Update title
    const title = document.querySelector('.main-content-title');
    if (title) {
        title.textContent = 'Edit Profile';
    }
}

export function cancelEdit() {
    // Hide delete account button before reload
    const deleteAccountDiv = document.querySelector('.profile-actions-right');
    if (deleteAccountDiv) {
        deleteAccountDiv.style.display = 'none';
    }
    window.location.reload();
}

// Initialize edit mode if page has errors (validation failed)
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('profileForm');
    if (form) {
        const hasErrors = form.querySelector('.form-input-error');
        if (hasErrors) {
            enableEditMode();
        }
    }
});

// Make functions globally available
window.enableEditMode = enableEditMode;
window.cancelEdit = cancelEdit;