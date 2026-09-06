<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LawyerController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lawyers',[LawyerController::class, 'index'])->name('lawyers.index');
Route::get('/lawyers/{id}', [LawyerController::class, 'show'])->name('lawyers.show');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'storeContact'])->name('contact.store');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'storeRegistration'])->name('register.store');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/book-appointment/{lawyerId}', [AppointmentController::class, 'create'])
         ->name('appointments.create');

    Route::post('/appointments', [AppointmentController::class, 'store'])
         ->name('appointments.store');

    Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])
         ->name('my-appointments');

    Route::get('/appointments/{id}', [AppointmentController::class, 'show'])->name('appointments.show');

    Route::get('/customer/dashboard', [HomeController::class, 'customerDashboard'])->name('customer.dashboard');
});
Route::middleware(['auth', 'lawyer'])->group(function () {

    Route::get('/lawyer/dashboard', [LawyerController::class, 'dashboard'])->name('lawyer.dashboard');

    Route::get('/lawyer/edit-profile', [LawyerController::class, 'editProfile'])->name('lawyer.edit-profile');

    Route::put('/lawyer/update-profile', [LawyerController::class, 'updateProfile'])->name('lawyer.update-profile');

    Route::get('/lawyer/appointments', [LawyerController::class, 'appointments'])->name('lawyer.appointments');

    Route::post('/appointments/{id}/update-status', [AppointmentController::class, 'updateStatus'])->name('appointments.update-status');

    Route::post('/notifications/{id}/read', [AppointmentController::class, 'markNotificationRead'])->name('notifications.read');
});

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/admin/lawyers', [AdminController::class, 'manageLawyers'])->name('admin.lawyers');

    Route::post('/admin/lawyers/{id}/approve', [AdminController::class, 'approveLawyer'])->name('admin.lawyers.approve');

    Route::post('/admin/lawyers/{id}/reject', [AdminController::class, 'rejectLawyer'])->name('admin.lawyers.reject');

    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');

    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

    Route::get('/admin/appointments', [AdminController::class, 'manageAppointments'])->name('admin.appointments');

    Route::get('/admin/services', [AdminController::class, 'manageServices'])->name('admin.services');

    Route::post('/admin/services', [AdminController::class, 'storeService'])->name('admin.services.store');

    Route::delete('/admin/services/{id}', [AdminController::class, 'deleteService'])->name('admin.services.delete');

    Route::get('/admin/messages', [AdminController::class, 'contactMessages'])->name('admin.messages');

    Route::delete('/admin/messages/{id}', [AdminController::class, 'destroyMessage'])->name('admin.messages.delete');
});