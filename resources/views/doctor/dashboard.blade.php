<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Doctor Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mt-4">
        <h1>Welcome, Dr. {{ Auth::user()->name }}</h1>
        <div class="mt-4">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
            <a href="{{ route('doctor.patients') }}" class="btn btn-success">View My Patients</a>
            <a href="{{ route('doctor.appointments') }}" class="btn btn-info">Manage Appointments</a>
        </div>
    </div>
</x-app-layout>
