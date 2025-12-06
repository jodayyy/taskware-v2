<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Taskware')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <x-ui.toast-container />
    
    <!-- Initialize sidebar state before render to prevent flash -->
    <script>
        (function() {
            const savedState = localStorage.getItem('sidebarExpanded');
            const isDesktop = window.innerWidth > 768;
            
            if (savedState !== 'true') return;
            
                const style = document.createElement('style');
                style.id = 'sidebar-initial-state';
            
            const commonStyles = `
                .icon-menu { display: none !important; }
                .icon-x { display: block !important; }
                .sidebar-nav-text { opacity: 1 !important; }
            `;
                
                if (isDesktop) {
                    style.textContent = `
                    #sidebar { width: 200px !important; transition: none !important; }
                    .sidebar-container { width: 200px !important; transition: none !important; }
                    ${commonStyles}
                    `;
                } else {
                    style.textContent = `
                    .sidebar-container { width: 200px !important; transition: none !important; }
                    #sidebar { width: 200px !important; transition: none !important; }
                    ${commonStyles}
                    `;
                }
                
                document.head.appendChild(style);
                
                function applyInitialState() {
                    const sidebar = document.getElementById('sidebar');
                    const mainLayout = document.querySelector('.main-layout');
                    
                    if (sidebar && mainLayout) {
                        if (isDesktop) {
                            sidebar.classList.add('expanded');
                            mainLayout.classList.add('sidebar-expanded');
                        } else {
                        sidebar.classList.add('mobile-open', 'expanded');
                            mainLayout.classList.add('sidebar-mobile-open');
                        }
                        
                    setTimeout(() => {
                            const initStyle = document.getElementById('sidebar-initial-state');
                        if (initStyle) initStyle.remove();
                        }, 50);
                    }
                }
                
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', applyInitialState);
                } else {
                    applyInitialState();
            }
        })();
    </script>
</head>
<body>
    @yield('content')
</body>
</html>