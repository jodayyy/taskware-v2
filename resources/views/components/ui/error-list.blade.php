@props(['errors'])

@php
    $wrapperClass = $attributes->get('class', '');
@endphp

@if ($errors->any())
    <div class="auth-error {{ $wrapperClass }}" {{ $attributes->except('class') }}>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

