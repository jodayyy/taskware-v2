@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <x-layout.page>
        <x-layout.container>
            <h1 class="main-content-title">Welcome, {{ Auth::user()->username }}!</h1>
            <p class="main-content-subtitle">This is your dashboard.</p>
        </x-layout.container>
    </x-layout.page>
@endsection