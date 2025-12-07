@props(['title' => null])

<div class="main-layout">
    <x-layout.topbar />
    
    <div class="main-content-wrapper">
        <div class="sidebar-container">
            <x-layout.sidebar />
        </div>
        
        <div class="main-content-area">
            <div class="main-content-container pb-6">
                <div class="main-content">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>

