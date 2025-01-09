<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Appointments') }}
        </h2>
    </x-slot>

    <div class="container mt-4">
        <h1>Appointments</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointment as $appointments)
                <tr>
                    <td>{{ $appointments->patient->name }}</td>
                    <td>{{ $appointments->doctor->name }}</td>
                    <td>{{ $appointments->appointment_date }}</td>
                    <td>{{ ucfirst($appointments->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
