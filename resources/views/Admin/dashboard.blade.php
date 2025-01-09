<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mt-4">
        <h1>Welcome, {{ Auth::user()->name }}</h1>
        <div class="mt-4">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
            <a href="{{ route('admin.users') }}" class="btn btn-success">Manage Users</a>
            <a href="{{ route('appointments.index') }}" class="btn btn-info">Manage Appointments</a>
        </div>
    </div>
</x-app-layout>
