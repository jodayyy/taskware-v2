@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="main-layout">
    <x-layout.sidebar />
    
    <div class="main-content-wrapper">
        <x-layout.topbar />
        
        <div class="dashboard-container">
            <div class="dashboard-content">
                <h1 class="dashboard-title">Welcome, {{ Auth::user()->username }}!</h1>
                <p class="dashboard-subtitle">This is your dashboard.</p>
            </div>
        </div>
    </div>
</div>
@endsection