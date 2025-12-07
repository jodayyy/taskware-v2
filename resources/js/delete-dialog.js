/**
 * Delete Confirmation Dialog Handler
 */

let escapeHandler = null;

function closeDialog(dialog) {
    dialog.style.display = 'none';
    document.body.style.overflow = '';
    if (escapeHandler) {
        document.removeEventListener('keydown', escapeHandler);
        escapeHandler = null;
    }
}

function openDialog(dialog, form) {
    dialog.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    const cancelBtn = dialog.querySelector('.delete-dialog-cancel');
    const confirmBtn = dialog.querySelector('.delete-dialog-confirm');
    
    // Remove any existing listeners by cloning
    const newCancelBtn = cancelBtn.cloneNode(true);
    const newConfirmBtn = confirmBtn.cloneNode(true);
    cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
    
    // Add new listeners
    newCancelBtn.addEventListener('click', () => closeDialog(dialog));
    
    newConfirmBtn.addEventListener('click', () => {
        form.submit();
    });
    
    // Close on overlay click
    const overlayHandler = (e) => {
        if (e.target === dialog) {
            closeDialog(dialog);
            dialog.removeEventListener('click', overlayHandler);
        }
    };
    dialog.addEventListener('click', overlayHandler);
    
    // Close on Escape key
    escapeHandler = (e) => {
        if (e.key === 'Escape') {
            closeDialog(dialog);
        }
    };
    document.addEventListener('keydown', escapeHandler);
}

export function initDeleteDialog() {
    const deleteButtons = document.querySelectorAll('[data-delete-dialog]');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const dialogId = this.getAttribute('data-delete-dialog');
            const formId = this.getAttribute('data-delete-form');
            const dialog = document.getElementById(dialogId);
            const form = formId ? document.getElementById(formId) : this.closest('form');
            
            if (!dialog || !form) {
                console.error('Delete dialog or form not found');
                return;
            }
            
            openDialog(dialog, form);
        });
    });
}

// Initialize on DOM load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDeleteDialog);
} else {
    initDeleteDialog();
}
