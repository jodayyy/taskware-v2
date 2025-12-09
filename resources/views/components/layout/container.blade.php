@props(['class' => ''])

<div class="main-content-container">
    <div class="main-content {{ $class }}">
        {{ $slot }}
    </div>
</div>

