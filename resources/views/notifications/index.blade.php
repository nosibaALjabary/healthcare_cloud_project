@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h1>Notifications</h1>
    </x-slot>

    <div class="container mt-4">
        <ul class="list-group">
            @foreach (auth()->user()->notifications as $notification)
                <li class="list-group-item {{ $notification->read_at ? '' : 'bg-light' }}">
                    <strong>{{ $notification->data['message'] }}</strong><br>
                    <small>
                        Date: {{ $notification->data['appointment_date'] }}<br>
                        Doctor: {{ $notification->data['doctor'] }}<br>
                        Status: {{ ucfirst($notification->data['status']) }}
                    </small>
                    @if (!$notification->read_at)
                        <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="mt-2">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-primary btn-sm">Mark as Read</button>
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endsection
