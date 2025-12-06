@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="main-layout">
    <x-layout.topbar />
    
    <div class="main-content-wrapper">
        <div class="sidebar-container">
            <x-layout.sidebar />
        </div>
        
        <div class="main-content-area">
            <div class="dashboard-container">
                <div class="dashboard-content">
                    <h1 class="dashboard-title">Welcome, {{ Auth::user()->username }}!</h1>
                    <p class="dashboard-subtitle">This is your dashboard.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection