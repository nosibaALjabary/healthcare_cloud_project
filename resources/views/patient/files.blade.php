<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Medical Files') }}
        </h2>
    </x-slot>

    <div class="container mt-4">
        <h1>My Medical Files</h1>

        @if (empty($files) || count($files) === 0)
            <p>No files found.</p>
        @else
            <ul class="list-group">
                @foreach ($files as $file)
                    <li class="list-group-item">
                        <a href="{{ asset('storage/' . $file) }}" target="_blank">
                            {{ basename($file) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        <div class="mt-4">
            <a href="{{ route('patient.uploadFile') }}" class="btn btn-primary">Upload New File</a>
        </div>
    </div>
</x-app-layout>
