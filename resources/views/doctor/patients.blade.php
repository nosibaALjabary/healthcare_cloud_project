<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Patients') }}
        </h2>
    </x-slot>

    <div class="container mt-4">
        <h1>My Patients</h1>
        @if ($patients->isEmpty())
            <p>No patients found.</p>
        @else
            <ul class="list-group">
                @foreach ($patients as $patient)
                <li class="list-group-item">
                    <strong>{{ $patient->name }}</strong> ({{ $patient->email }})
                </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-app-layout>
