<nav class="topbar">
    <div class="topbar-container">
        <div class="topbar-brand">
            <h2 class="topbar-title">Taskware</h2>
        </div>
        <div class="topbar-actions">
            <form method="POST" action="{{ route('logout') }}" class="topbar-logout-form">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg class="logout-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</nav>



