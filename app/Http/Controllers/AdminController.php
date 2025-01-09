<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment;

class AdminController extends Controller
{
    public function index()
{
    $users = User::all();
    $appointments = Appointment::all();

    return view('admin.dashboard', compact('users', 'appointments'));
}
public function manageUsers()
{
    $users = User::all();
    return view('admin.users', compact('users'));
}
public function manageAppointments()
{
    $appointments = Appointment::with(['patient', 'doctor'])->get();
    return view('admin.appointments', compact('appointments'));
}
public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
