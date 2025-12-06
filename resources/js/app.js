import './bootstrap';
import * as passwordValidation from './password-validation';

// Make password validation functions globally available
window.passwordValidation = passwordValidation;

// Sidebar toggle functionality
(function() {
    // Initialize sidebar state immediately to prevent flash
    const sidebar = document.getElementById('sidebar');
    const mainLayout = document.querySelector('.main-layout');
    const iconMenu = document.querySelector('.icon-menu');
    const iconX = document.querySelector('.icon-x');
    
    if (sidebar && mainLayout) {
        // Check localStorage for saved state
        const savedState = localStorage.getItem('sidebarExpanded');
        if (savedState === 'true') {
            sidebar.classList.add('expanded');
            mainLayout.classList.add('sidebar-expanded');
            // Update icon visibility immediately
            if (iconMenu && iconX) {
                iconMenu.style.display = 'none';
                iconX.style.display = 'block';
            }
        }
    }
})();

// Handle sidebar toggle after DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainLayout = document.querySelector('.main-layout');
    const iconMenu = document.querySelector('.icon-menu');
    const iconX = document.querySelector('.icon-x');
    
    // Function to update icon visibility
    function updateIconVisibility(isExpanded) {
        if (iconMenu && iconX) {
            if (isExpanded) {
                iconMenu.style.display = 'none';
                iconX.style.display = 'block';
            } else {
                iconMenu.style.display = 'block';
                iconX.style.display = 'none';
            }
        }
    }
    
    // Initialize icon visibility based on saved state
    if (sidebar && iconMenu && iconX) {
        const savedState = localStorage.getItem('sidebarExpanded');
        const isExpanded = savedState === 'true' || sidebar.classList.contains('expanded');
        updateIconVisibility(isExpanded);
    }
    
    if (sidebar && sidebarToggle && mainLayout) {
        sidebarToggle.addEventListener('click', function() {
            const isExpanded = sidebar.classList.contains('expanded');
            
            if (isExpanded) {
                sidebar.classList.remove('expanded');
                mainLayout.classList.remove('sidebar-expanded');
                localStorage.setItem('sidebarExpanded', 'false');
                updateIconVisibility(false);
            } else {
                sidebar.classList.add('expanded');
                mainLayout.classList.add('sidebar-expanded');
                localStorage.setItem('sidebarExpanded', 'true');
                updateIconVisibility(true);
            }
        });
    }
});