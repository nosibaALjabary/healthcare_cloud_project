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
    // التحقق من صحة المدخلات
    $validated = $request->validate([
        'doctor_id' => 'required|exists:users,id',  // التحقق من أن الطبيب موجود في قاعدة البيانات
        'appointment_date' => 'required|date|after:now',  // التحقق من أن تاريخ الموعد صالح
    ]);

    // التحقق من تعارض المواعيد (التأكد من عدم وجود موعد آخر للطبيب في نفس الوقت)
    $existingAppointment = Appointment::where('doctor_id', $validated['doctor_id'])
                                      ->where('appointment_date', $validated['appointment_date'])
                                      ->exists();

    if ($existingAppointment) {
        // إذا كان هناك تعارض في المواعيد، إرجاع رسالة خطأ
        return back()->with('error', 'The doctor is already booked for this time.');
    }

    // إنشاء الموعد الجديد
    $appointment = Appointment::create([
        'patient_id' => auth()->user()->id,  // استخدام معرّف المريض الحالي
        'doctor_id' => $validated['doctor_id'],  // معرّف الطبيب المختار
        'appointment_date' => $validated['appointment_date'],  // تاريخ ووقت الموعد
        'status' => 'pending',  // تعيين حالة الموعد إلى "معلق"
    ]);

    // الحصول على تفاصيل الطبيب
    $doctor = User::find($validated['doctor_id']);

    // إعداد تفاصيل البريد الإلكتروني للمريض
    $details = [
        'name' => auth()->user()->name,
        'message' => 'You have successfully booked an appointment.',
        'appointment_date' => $validated['appointment_date'],
        'doctor' => $doctor->name,
        'status' => 'pending',
    ];

    // إرسال البريد الإلكتروني للمريض
    Mail::to(auth()->user()->email)->send(new AppointmentNotification($details));

    // إرسال البريد الإلكتروني للطبيب
    $doctorDetails = [
        'name' => $doctor->name,
        'patient_name' => auth()->user()->name,
        'appointment_date' => $validated['appointment_date'],
    ];

    Mail::to($doctor->email)->send(new AppointmentNotification($doctorDetails));

    // إعادة التوجيه إلى لوحة تحكم المريض مع رسالة نجاح
    return redirect()->route('patient.dashboard')->with('success', 'Appointment booked and email sent!');
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
