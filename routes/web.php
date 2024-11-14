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
Route::get('/reset-password/{token}/{email}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.form');
Route::post('/reset-password/{token}/{email}', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');  // Submit new password
//end forgot password route

// start admin route
Route::name('admin.')->prefix('admin')->middleware('role')->group(function () {
    Route::get('/panel', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'showUsers'])->name('users');
    Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('show.user');
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('delete.user');
    Route::get('/users/update/{id}', [AdminController::class, 'showUpdateUser'])->name('show.update.user');
    Route::put('/users/update/{id}', [AdminController::class, 'updateUser'])->name('update.user');
    Route::get('/create-user', [AdminController::class, 'showCreateUser'])->name('create.show');
    Route::post('/create-user', [AdminController::class, 'create'])->name('create.user');
    Route::get('/settings', [AdminController::class, 'showSetting'])->name('setting.show');
    Route::put('/settings', [AdminController::class, 'updateSetting'])->name('setting.update');
    Route::get('/powers/{id}', [AdminController::class, 'showPowers'])->name('powers.show');
    Route::put('/powers/{id}', [AdminController::class, 'updatePowers'])->name('powers.update');
    Route::post('/powers/{id}', [AdminController::class, 'storeTechProjectsPower'])->name('powers.store.tech');
    Route::get('/projects/create/{step}', [AdminController::class, 'showCreateProject'])->name('new.project.show');
    Route::post('/projects/create/{step}', [AdminController::class, 'createProject'])->name('create.project');
});
// end admin route

// start employee route
Route::name('employee.')->prefix('employee')->middleware('role')->group(function () {
    Route::get('/panel', [EmployeeController::class, 'index'])->name('employee.dashboard');
    Route::get('/profile', [EmployeeController::class, 'show'])->name('profile.show');
});
// end employee route

Route::get('/', [ProjectsController::class, 'index'])->name('home');
Route::get('/tech-projects/{id}', [ProjectsController::class, 'techProjects'])->name('tech');
