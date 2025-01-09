<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class DoctorController extends Controller
{
    public function index()
{
    $appointments = Appointment::where('doctor_id', auth()->user()->id)
                                ->with('patient')
                                ->get();
    return view('doctor.dashboard', compact('appointments'));
}
public function managePatients()
{
    $patients = Appointment::where('doctor_id', auth()->user()->id)
                           ->with('patient')
                           ->get()
                           ->pluck('patient')
                           ->unique();
    return view('doctor.patients', compact('patients'));
}
public function manageAppointments()
{
    $appointments = Appointment::where('doctor_id', auth()->user()->id)
                                ->get();
    return view('doctor.appointments', compact('appointments'));
}

public function updateAppointmentStatus($id, $status)
{
    $appointment = Appointment::findOrFail($id);
    $appointment->status = $status;
    $appointment->save();

    return redirect()->back()->with('success', 'Appointment status updated!');
}

}
