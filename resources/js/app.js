import './bootstrap';

// Sidebar toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainLayout = document.querySelector('.main-layout');
    
    if (sidebar && sidebarToggle && mainLayout) {
        // Check localStorage for saved state (default to collapsed)
        const savedState = localStorage.getItem('sidebarExpanded');
        if (savedState === 'true') {
            sidebar.classList.add('expanded');
            mainLayout.classList.add('sidebar-expanded');
        }
        
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('expanded');
            mainLayout.classList.toggle('sidebar-expanded');
            // Save state to localStorage
            localStorage.setItem('sidebarExpanded', sidebar.classList.contains('expanded'));
        });
    }
});