<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LawyerController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lawyers', [LawyerController::class, 'index'])->name('lawyers.index');
Route::get('/lawyers/{id}', [LawyerController::class, 'show'])->name('lawyers.show');

// Static content pages
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');

// Contact form
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'storeContact'])->name('contact.store');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'storeRegistration'])->name('register.store');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot / Reset Password
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::middleware(['auth'])->group(function () {

    // Appointments
    Route::get('/book-appointment/{lawyerId}', [AppointmentController::class, 'create'])
         ->name('appointments.create');

    Route::post('/appointments', [AppointmentController::class, 'store'])
         ->name('appointments.store');

    Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])
         ->name('my-appointments');

    Route::get('/appointments/{id}', [AppointmentController::class, 'show'])->name('appointments.show');

    // Customer cancels an appointment (pending or approved only)
    Route::delete('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])
         ->name('appointments.cancel');

    // Customer rates a completed appointment
    Route::post('/appointments/{id}/rate', [AppointmentController::class, 'rate'])
         ->name('appointments.rate');

    // Notification "mark as read"
    Route::post('/notifications/{id}/read', [AppointmentController::class, 'markNotificationRead'])
         ->name('notifications.read');

    // Notification "delete" (single or all)
    Route::delete('/notifications/{id}/delete', [AppointmentController::class, 'deleteNotification'])
         ->name('notifications.delete');

    // All notifications page
    Route::get('/notifications', [AppointmentController::class, 'showNotifications'])
         ->name('notifications.index');

    // Customer dashboard + profile
    Route::get('/customer/dashboard', [HomeController::class, 'customerDashboard'])->name('customer.dashboard');
    Route::get('/customer/profile/edit', [HomeController::class, 'editCustomerProfile'])->name('customer.profile.edit');
    Route::put('/customer/profile/update', [HomeController::class, 'updateCustomerProfile'])->name('customer.profile.update');
    Route::get('/customer/password/edit', [HomeController::class, 'editPassword'])->name('customer.password.edit');
    Route::put('/customer/password/update', [HomeController::class, 'updatePassword'])->name('customer.password.update');
});

Route::middleware(['auth', 'lawyer'])->group(function () {

    Route::get('/lawyer/dashboard', [LawyerController::class, 'dashboard'])->name('lawyer.dashboard');
    Route::get('/lawyer/edit-profile', [LawyerController::class, 'editProfile'])->name('lawyer.edit-profile');
    Route::put('/lawyer/update-profile', [LawyerController::class, 'updateProfile'])->name('lawyer.update-profile');
    Route::get('/lawyer/appointments', [LawyerController::class, 'appointments'])->name('lawyer.appointments');

    // Lawyer change password (mirrors the customer's flow at the same URL location)
    Route::get('/lawyer/password/edit', [LawyerController::class, 'editPassword'])->name('lawyer.password.edit');
    Route::put('/lawyer/password/update', [LawyerController::class, 'updatePassword'])->name('lawyer.password.update');

    Route::post('/appointments/{id}/update-status', [AppointmentController::class, 'updateStatus'])
         ->name('appointments.update-status');
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

    // Homepage content management
    Route::get('/admin/content', [AdminController::class, 'editContent'])->name('admin.content');
    Route::put('/admin/content', [AdminController::class, 'updateContent'])->name('admin.content.update');
});
