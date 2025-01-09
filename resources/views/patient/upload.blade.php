@extends('layouts.app')

@section('content')
    <h1>Upload Medical File</h1>

    <form action="{{ route('patient.uploadMedicalFile') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@endsection
