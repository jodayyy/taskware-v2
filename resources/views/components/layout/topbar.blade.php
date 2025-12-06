<nav class="topbar">
    <div class="topbar-container">
        <div class="topbar-left">
            <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
                <span class="icon-menu">
                    <x-icons.menu />
                </span>
                <span class="icon-x" style="display: none;">
                    <x-icons.x />
                </span>
            </button>
            <h2 class="topbar-brand">Taskware</h2>
        </div>
        <div class="topbar-actions">
            <form method="POST" action="{{ route('logout') }}" class="topbar-logout-form">
                @csrf
                <button type="submit" class="btn-logout">
                    <x-icons.logout />
                </button>
            </form>
        </div>
    </div>
</nav>