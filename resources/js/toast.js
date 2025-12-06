/**
 * Toast Notification System
 * Floating notifications for success, error, and info messages
 */

class ToastManager {
    constructor() {
        this.container = null;
        this.init();
    }

    init() {
        // Create toast container if it doesn't exist
        if (!document.getElementById('toast-container')) {
            this.container = document.createElement('div');
            this.container.id = 'toast-container';
            this.container.className = 'toast-container';
            document.body.appendChild(this.container);
        } else {
            this.container = document.getElementById('toast-container');
        }
    }

    show(title, description = '', type = 'info', duration = 5000) {
        const toastId = 'toast-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
        const typeClasses = {
            success: 'toast-success',
            error: 'toast-error',
            info: 'toast-info',
        };
        const typeClass = typeClasses[type] || typeClasses['info'];

        const toast = document.createElement('div');
        toast.id = toastId;
        toast.className = `toast ${typeClass}`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');

        const descriptionHtml = description ? `<p class="toast-description">${this.escapeHtml(description)}</p>` : '';

        toast.innerHTML = `
            <div class="toast-content">
                <div class="toast-body">
                    <h4 class="toast-title">${this.escapeHtml(title)}</h4>
                    ${descriptionHtml}
                </div>
                <button type="button" class="toast-close" aria-label="Close" onclick="this.closest('.toast').remove()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;

        this.container.appendChild(toast);

        // Trigger animation
        requestAnimationFrame(() => {
            toast.classList.add('toast-show');
        });

        // Auto remove after duration
        if (duration > 0) {
            setTimeout(() => {
                this.remove(toastId);
            }, duration);
        }

        return toastId;
    }

    success(title, description = '', duration = 5000) {
        return this.show(title, description, 'success', duration);
    }

    error(title, description = '', duration = 7000) {
        return this.show(title, description, 'error', duration);
    }

    info(title, description = '', duration = 5000) {
        return this.show(title, description, 'info', duration);
    }

    remove(toastId) {
        const toast = document.getElementById(toastId);
        if (toast) {
            toast.classList.remove('toast-show');
            toast.classList.add('toast-hide');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Create global instance
const toast = new ToastManager();

// Make available globally
window.toast = toast;

// Auto-show session flash messages
document.addEventListener('DOMContentLoaded', function() {
    // Handle success messages (title + description format)
    const successMessages = document.querySelectorAll('[data-toast-success]');
    successMessages.forEach(element => {
        const message = element.getAttribute('data-toast-success');
        toast.success('Success', message);
        element.remove();
    });

    // Handle error messages (title + description format)
    const errorMessages = document.querySelectorAll('[data-toast-error]');
    errorMessages.forEach(element => {
        const errorMessage = element.getAttribute('data-toast-error');
        toast.error('Error', errorMessage);
        element.remove();
    });

    // Handle info messages (title + description format)
    const infoMessages = document.querySelectorAll('[data-toast-info]');
    infoMessages.forEach(element => {
        const message = element.getAttribute('data-toast-info');
        toast.info('Info', message);
        element.remove();
    });
});

export default toast;

