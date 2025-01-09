<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Delete Account') }}
        </h2>
    </x-slot>

    <div class="container mt-4">
        <h1>Delete Account</h1>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')

            <div class="mb-3">
                <label for="password" class="form-label">Current Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-danger">Delete Account</button>
        </form>
    </div>
</x-app-layout>
