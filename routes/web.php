<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PowersController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UsersController;

// start auth routes
Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
// end auth routes

//start forgot password route
Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot.password');  // Show forgot password form
Route::post('/verification', [ForgotPasswordController::class, 'verification'])->name('verification');  // Send verification OTP
Route::post('/resend-otp/{user}', [ForgotPasswordController::class, 'sendOtp'])->name('resend.otp');
Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('otp.verify');  // Verify OTP and generate token
Route::get('/reset-password/{token}/{email}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.form');
Route::post('/reset-password/{token}/{email}', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');  // Submit new password
//end forgot password route

// start admin route
Route::name('admin.')->prefix('admin')->middleware('role')->group(function () {
    Route::get('/panel', [AdminController::class, 'index'])->name('dashboard');
    
    //start users route
    Route::get('/users', [UsersController::class, 'index'])->name('users');
    Route::get('/users/{id}', [UsersController::class, 'show'])->name('show.user');
    Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('delete.user');
    Route::get('/users/update/{id}', [UsersController::class, 'showUpdateUser'])->name('show.update.user');
    Route::put('/users/update/{id}', [UsersController::class, 'update'])->name('update.user');
    Route::get('/create-user', [UsersController::class, 'showCreateUser'])->name('create.show');
    Route::post('/create-user', [UsersController::class, 'create'])->name('create.user');
    //end users route
    
    //start settings route
    Route::get('/settings', [SettingController::class, 'index'])->name('setting.show');
    Route::put('/settings', [SettingController::class, 'update'])->name('setting.update');
    //end settings route
    
    //start powers route
    Route::get('/powers/{id}', [PowersController::class, 'index'])->name('powers.show');
    Route::post('/powers/{id}', [PowersController::class, 'update'])->name('powers.update');
    // Route::post('/powers/{id}', [PowersController::class, 'store'])->name('powers.store.tech');
    //end powers route

    Route::get('/projects/create/{step}', [ProjectController::class, 'index'])->name('new.project.show');
    Route::post('/projects/create/{step}', [ProjectController::class, 'create'])->name('create.project');
    Route::post('/projects/create', [ProjectController::class, 'finalCreateProject'])->name('create.project.final');
});
// end admin route

// start employee route
Route::name('employee.')->prefix('employee')->middleware('role')->group(function () {
    Route::get('/panel', [EmployeeController::class, 'index'])->name('dashboard');
    Route::get('/settings', [AdminController::class, 'showSetting'])->name('setting.show');
    Route::put('/settings', [AdminController::class, 'updateSetting'])->name('setting.update');
});
// end employee route

Route::get('/', [ProjectsController::class, 'index'])->name('home');
Route::get('/tech-projects/{id}', [ProjectsController::class, 'techProjects'])->name('tech');
