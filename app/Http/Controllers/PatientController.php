<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Storage;


class PatientController extends Controller
{
    public function index()
{
    $appointments = Appointment::where('patient_id', auth()->user()->id)
                                ->with('doctor')
                                ->get();
    return view('patient.dashboard', compact('appointments'));
}
public function bookAppointment(Request $request)
{
    $validated = $request->validate([
        'doctor_id' => 'required|exists:users,id',
        'appointment_date' => 'required|date|after:now',
    ]);

    $appointment = Appointment::create([
        'patient_id' => auth()->user()->id,
        'doctor_id' => $validated['doctor_id'],
        'appointment_date' => $validated['appointment_date'],
        'status' => 'pending',
    ]);

    return redirect()->route('patient.dashboard')->with('success', 'Appointment booked!');
}
public function uploadMedicalFile(Request $request)
{
    $request->validate(['file' => 'required|file|mimes:jpg,png,pdf']);

    $path = $request->file('file')->store('medical-files');

    // يمكنك حفظ مسار الملف في قاعدة البيانات إذا لزم الأمر
    return redirect()->back()->with('success', 'File uploaded successfully!');
}
public function viewFiles()
{
    $files = Storage::files('medical-files/' . auth()->user()->id);

    return view('patient.files', compact('files'));
}

public function appointments()
{
    $appointments = Appointment::where('patient_id', auth()->user()->id)->get();

    return view('patient.appointments', compact('appointments'));
}
}
