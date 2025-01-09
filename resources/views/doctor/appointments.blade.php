<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Appointments') }}
        </h2>
    </x-slot>

    <div class="container mt-4">
        <h1>My Appointments</h1>
        @if ($appointments->isEmpty())
            <p>No appointments found.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->patient->name }}</td>
                        <td>{{ $appointment->appointment_date->format('Y-m-d') }}</td>
                        <td>{{ $appointment->appointment_date->format('H:i') }}</td>
                        <td>{{ ucfirst($appointment->status) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
