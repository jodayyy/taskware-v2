@props(['class' => ''])

<div class="main-content-container pb-6">
    <div class="main-content {{ $class }}">
        {{ $slot }}
    </div>
</div>

