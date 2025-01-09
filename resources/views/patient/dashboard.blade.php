<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patient Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mt-4">
        <h1>Welcome, {{ Auth::user()->name }}</h1>
        
        <div class="mt-4">
            <!-- رابط تعديل الملف الشخصي -->
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
            
            <!-- رابط عرض المواعيد -->
            <a href="{{ route('patient.appointments') }}" class="btn btn-success">View Appointments</a>
            
            <!-- رابط إضافة موعد جديد -->
            <a href="{{ route('appointments.book') }}" class="btn btn-info">Make an Appointment</a>
            </div>
    </div>
</x-app-layout>
