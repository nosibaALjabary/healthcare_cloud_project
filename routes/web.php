<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;


// الصفحة الرئيسية (Redirect إلى تسجيل الدخول)
Route::get('/', function () {
    return redirect('/login');
});

// مسارات المصادقة (Laravel Breeze)
require __DIR__.'/auth.php';

// مسارات محمية بـ Middleware 'auth'
Route::middleware('auth')->group(function () {

    // المسار العام للـ Dashboard بناءً على الدور
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'doctor':
                return redirect()->route('doctor.dashboard');
            case 'patient':
                return redirect()->route('patient.dashboard');
            default:
                return abort(403, 'Unauthorized');
        }
    })->name('dashboard');

    /**
     * مسارات المدير (Admin)
     */
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'manageUsers'])->name('users');
        Route::get('/appointments', [AdminController::class, 'manageAppointments'])->name('appointments');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('deleteUser');
    });

    /**
     * مسارات الطبيب (Doctor)
     */
    Route::prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/dashboard', [DoctorController::class, 'index'])->name('dashboard');
        Route::get('/patients', [DoctorController::class, 'managePatients'])->name('patients');
        Route::get('/appointments', [DoctorController::class, 'manageAppointments'])->name('appointments');
        Route::put('/appointments/{id}/{status}', [DoctorController::class, 'updateAppointmentStatus'])->name('updateAppointmentStatus');
    });

    /**
     * مسارات المريض (Patient)
     */
    Route::prefix('patient')->name('patient.')->group(function () {
        Route::get('/dashboard', [PatientController::class, 'index'])->name('dashboard');
       // Route::post('/appointments/book', [PatientController::class, 'bookAppointment'])->name('bookAppointment');
        Route::get('/files', [PatientController::class, 'viewFiles'])->name('viewFiles');
        Route::post('/files/upload', [PatientController::class, 'uploadMedicalFile'])->name('uploadFile');
        Route::get('/appointments', [PatientController::class, 'appointments'])->name('appointments');
    });

    /**
     * مسارات المواعيد (Appointments)
     */
    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::post('/book', [AppointmentController::class, 'bookAppointment'])->name('book');
        Route::get('/user', [AppointmentController::class, 'getAppointmentsByUser'])->name('getByUser');
        Route::put('/{id}/status', [AppointmentController::class, 'updateAppointmentStatus'])->name('updateStatus');
        Route::delete('/{id}/cancel', [AppointmentController::class, 'cancelAppointment'])->name('cancel');
        Route::get('/', [AppointmentController::class, 'index'])->name('index');
    });

    /**
     * مسارات الملف الشخصي (Profile)
     */
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/update', [ProfileController::class, 'update'])->name('update');
        Route::delete('/delete', [ProfileController::class, 'destroy'])->name('destroy');
    });

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});



});
