<nav class="topbar">
    <div class="topbar-container">
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