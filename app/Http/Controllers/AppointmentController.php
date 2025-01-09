<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Mail\AppointmentNotification;
use Illuminate\Support\Facades\Mail;
use App\Notifications\AppointmentStatusNotification;


class AppointmentController extends Controller
{
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
public function getAppointmentsByUser(Request $request)
{
    $appointments = Appointment::where('patient_id', $request->user()->id)
                                ->orWhere('doctor_id', $request->user()->id)
                                ->with(['patient', 'doctor'])
                                ->get();

    return response()->json($appointments);
}
public function cancelAppointment($id)
{
    $appointment = Appointment::findOrFail($id);
    $appointment->status = 'cancelled';
    $appointment->save();

    return response()->json(['message' => 'Appointment cancelled successfully.']);
}
public function index()
{
    // من الممكن استرجاع بيانات المواعيد من قاعدة البيانات، على سبيل المثال:
    $appointment = Appointment::all();  // تأكد من أنك لديك موديل Appointment

    return view('appointments.index', compact('appointment'));
}

public function updateAppointmentStatus(Request $request, $id)
{
    $appointment = Appointment::findOrFail($id);
    $appointment->status = $request->status; // confirmed or cancelled
    $appointment->save();

    $details = [
        'message' => 'Your appointment status has been updated.',
        'appointment_date' => $appointment->appointment_date,
        'doctor' => $appointment->doctor->name,
        'status' => $appointment->status,
    ];

    $appointment->patient->notify(new AppointmentStatusNotification($details));

    return redirect()->back()->with('success', 'Appointment status updated and notification sent!');
}

}
