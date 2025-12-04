import './bootstrap';
import * as passwordValidation from './password-validation';

// Make password validation functions globally available
window.passwordValidation = passwordValidation;

// Sidebar toggle functionality
(function() {
    // Initialize sidebar state immediately to prevent flash
    const sidebar = document.getElementById('sidebar');
    const mainLayout = document.querySelector('.main-layout');
    
    if (sidebar && mainLayout) {
        // Check localStorage for saved state
        const savedState = localStorage.getItem('sidebarExpanded');
        if (savedState === 'true') {
            sidebar.classList.add('expanded');
            mainLayout.classList.add('sidebar-expanded');
        }
    }
})();

// Handle sidebar toggle after DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainLayout = document.querySelector('.main-layout');
    
    if (sidebar && sidebarToggle && mainLayout) {
        sidebarToggle.addEventListener('click', function() {
            const isExpanded = sidebar.classList.contains('expanded');
            
            if (isExpanded) {
                sidebar.classList.remove('expanded');
                mainLayout.classList.remove('sidebar-expanded');
                localStorage.setItem('sidebarExpanded', 'false');
            } else {
                sidebar.classList.add('expanded');
                mainLayout.classList.add('sidebar-expanded');
                localStorage.setItem('sidebarExpanded', 'true');
            }
        });
    }
});