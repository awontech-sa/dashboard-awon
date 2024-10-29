<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ForgotPasswordController;

// start auth routes
Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
// end auth routes

//start forgot password route
Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot.password');  // Show forgot password form
Route::post('/verification', [ForgotPasswordController::class, 'verification'])->name('verification');  // Send verification OTP
Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('otp.verify');  // Verify OTP and generate token
// Route::get('/reset-password', [ForgotPasswordController::class, 'showResetPasswordForm']);
Route::get('/reset-password/{token}/{email}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.form');
Route::post('/reset-password/{token}/{email}', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');  // Submit new password
//end forgot password route

// start role route
Route::group(['middleware' => 'role'], function () {
    // start admin routes
    Route::get('admin/panel', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/users', [AdminController::class, 'showUsers'])->name('admin.users');
    Route::get('admin/settings', [AdminController::class, 'showSetting'])->name('setting.show');
    Route::put('admin/settings', [AdminController::class, 'updateSetting'])->name('setting.update');
    Route::get('admin/powers', [AdminController::class, 'showPowers'])->name('powers.show');
    // end admin routes

    // start employee routes
    Route::get('employee/panel', [EmployeeController::class, 'index'])->name('employee.dashboard');
    Route::get('employee/profile', [EmployeeController::class, 'show'])->name('profile.show');
    // end employee routes
});
// end role route

Route::get('/', [ProjectsController::class, 'index'])->name('home');
Route::get('/tech-projects/{id}', [ProjectsController::class, 'techProjects'])->name('tech');
