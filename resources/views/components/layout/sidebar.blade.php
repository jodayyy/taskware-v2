<aside class="sidebar" id="sidebar">
    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="sidebar-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <x-icons.dashboard />
            <span class="sidebar-nav-text">Dashboard</span>
        </a>
        <a href="{{ route('projects.index') }}" class="sidebar-nav-item {{ request()->routeIs('projects.*') ? 'active' : '' }}">
            <x-icons.project />
            <span class="sidebar-nav-text">Projects</span>
        </a>
        <a href="{{ route('tasks.index') }}" class="sidebar-nav-item {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
            <x-icons.task />
            <span class="sidebar-nav-text">Tasks</span>
        </a>
        <a href="{{ route('profile.show') }}" class="sidebar-nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <x-icons.profile />
            <span class="sidebar-nav-text">Profile</span>
        </a>
    </nav>
</aside>