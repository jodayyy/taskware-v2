// Helper function to check if mobile view
function isMobileView() {
    return window.innerWidth <= 768;
}

// Helper function to update icon visibility
function updateIconVisibility(iconMenu, iconX, isExpanded) {
    if (iconMenu && iconX) {
        iconMenu.style.display = isExpanded ? 'none' : 'block';
        iconX.style.display = isExpanded ? 'block' : 'none';
    }
}

// Helper function to apply sidebar state
function applySidebarState(sidebar, mainLayout, iconMenu, iconX, isExpanded, isMobile) {
    if (isMobile) {
        sidebar.classList.toggle('mobile-open', isExpanded);
        sidebar.classList.toggle('expanded', isExpanded);
        mainLayout.classList.toggle('sidebar-mobile-open', isExpanded);
    } else {
        sidebar.classList.toggle('expanded', isExpanded);
        mainLayout.classList.toggle('sidebar-expanded', isExpanded);
    }
    updateIconVisibility(iconMenu, iconX, isExpanded);
}

// Helper function to get current sidebar state
function getSidebarState(sidebar, isMobile) {
    return isMobile 
        ? sidebar.classList.contains('mobile-open')
        : sidebar.classList.contains('expanded');
}

// Sidebar toggle functionality
(function() {
    const sidebar = document.getElementById('sidebar');
    const mainLayout = document.querySelector('.main-layout');
    const iconMenu = document.querySelector('.icon-menu');
    const iconX = document.querySelector('.icon-x');
    
    if (!sidebar || !mainLayout) return;
    
    const isMobile = isMobileView();
    const stateKey = isMobile ? 'mobile-open' : 'expanded';
    const layoutKey = isMobile ? 'sidebar-mobile-open' : 'sidebar-expanded';
    const alreadyInitialized = sidebar.classList.contains(stateKey) || 
                              mainLayout.classList.contains(layoutKey);
            
            if (!alreadyInitialized) {
        const savedState = localStorage.getItem('sidebarExpanded') === 'true';
        applySidebarState(sidebar, mainLayout, iconMenu, iconX, savedState, isMobile);
                } else {
        updateIconVisibility(iconMenu, iconX, getSidebarState(sidebar, isMobile));
    }
})();

// Handle sidebar toggle after DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainLayout = document.querySelector('.main-layout');
    const iconMenu = document.querySelector('.icon-menu');
    const iconX = document.querySelector('.icon-x');
    
    if (!sidebar || !mainLayout) return;
    
    // Unified toggle function
    function toggleSidebar() {
        const isMobile = isMobileView();
        const currentState = getSidebarState(sidebar, isMobile);
        const newState = !currentState;
        
        applySidebarState(sidebar, mainLayout, iconMenu, iconX, newState, isMobile);
        localStorage.setItem('sidebarExpanded', String(newState));
    }
    
    // Initialize icon visibility based on current view
    if (iconMenu && iconX) {
        updateIconVisibility(iconMenu, iconX, getSidebarState(sidebar, isMobileView()));
    }
    
    // Handle sidebar toggle click
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }
    
    // Handle window resize - restore state from localStorage when switching views
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            const isMobile = isMobileView();
            const savedState = localStorage.getItem('sidebarExpanded') === 'true';
            
            // Clear all states first
            sidebar.classList.remove('expanded', 'mobile-open');
            mainLayout.classList.remove('sidebar-mobile-open', 'sidebar-expanded');
            
            // Apply saved state for current view
            applySidebarState(sidebar, mainLayout, iconMenu, iconX, savedState, isMobile);
        }, 100);
    });
});

