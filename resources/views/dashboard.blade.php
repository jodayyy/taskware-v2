@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<x-layout.page>
                    <h1 class="dashboard-title">Welcome, {{ Auth::user()->username }}!</h1>
                    <p class="dashboard-subtitle">This is your dashboard.</p>
</x-layout.page>
@endsection