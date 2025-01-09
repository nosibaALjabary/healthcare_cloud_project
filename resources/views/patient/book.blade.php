@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Book Appointment</h1>
    <form action="{{ route('patient.bookAppointment') }}" method="POST" class="card p-4">
        @csrf
        <div class="mb-3">
            <label for="doctor" class="form-label">Choose Doctor</label>
            <select name="doctor_id" id="doctor" class="form-select">
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">Dr. {{ $doctor->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="appointment_date" class="form-label">Date and Time</label>
            <input type="datetime-local" name="appointment_date" id="appointment_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Book Appointment</button>
    </form>
</div>
@endsection
