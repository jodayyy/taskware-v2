@props(['title' => null])

<div class="main-layout">
    <x-layout.topbar />
    
    <div class="main-content-wrapper">
        <div class="sidebar-container">
            <x-layout.sidebar />
        </div>
        
        <div class="main-content-area">
            <div class="dashboard-container">
                <div class="dashboard-content">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>

