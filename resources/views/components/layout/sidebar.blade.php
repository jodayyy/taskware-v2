<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
            <x-icons.menu />
        </button>
        <h2 class="sidebar-brand">Taskware</h2>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="sidebar-nav-item">
            <x-icons.dashboard />
            <span class="sidebar-nav-text">Dashboard</span>
        </a>
        <a href="{{ route('profile.show') }}" class="sidebar-nav-item">
            <x-icons.profile />
            <span class="sidebar-nav-text">Profile</span>
        </a>
    </nav>
</aside>