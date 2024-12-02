<?php

// start auth routes

use App\Http\Controllers\AdminController\AdminController;
use App\Http\Controllers\AdminController\PowersController;
use App\Http\Controllers\AdminController\ProjectController;
use App\Http\Controllers\AdminController\SettingController;
use App\Http\Controllers\AdminController\UsersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController\EmployeeController;
use App\Http\Controllers\EmployeeController\ProfileController;
use App\Http\Controllers\EmployeeController\ProjectController as EmployeeProjectController;
use App\Http\Controllers\EmployeeController\SettingController as EmployeeSettingController;
use App\Http\Controllers\EmployeeController\UsersController as EmployeeUserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [VisitorController::class, 'index'])->name('home');
Route::get('/{id}', [VisitorController::class, 'show'])->name('tech');
Route::get('/login', [AuthController::class, 'index'])->name('login');
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
    Route::get('/percentage-projects', [AdminController::class, 'show'])->name('percentage');

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

    Route::get('/project/{id}', [ProjectController::class, 'show'])->name('show.project');
    Route::delete('/project/{id}', [ProjectController::class, 'destroy'])->name('delete.project');
});
// end admin route

// start employee route
Route::name('employee.')->prefix('employee')->middleware('role')->group(function () {
    Route::get('/panel', [EmployeeController::class, 'index'])->name('dashboard');
    Route::get('/projects-percentage', [EmployeeController::class, 'show'])->name('percentage');

    //start setting route
    Route::get('/settings', [EmployeeSettingController::class, 'index'])->name('setting.show');
    Route::put('/settings', [EmployeeSettingController::class, 'update'])->name('setting.update');
    //end setting route

    //start profile route
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.show');
    //end profile route

    //start users route
    Route::get('/users', [EmployeeUserController::class, 'index'])->name('users');
    Route::get('/users/{id}', [EmployeeUserController::class, 'show'])->name('show.user');
    Route::delete('/users/{id}', [EmployeeUserController::class, 'destroy'])->name('delete.user');
    Route::get('/users/update/{id}', [EmployeeUserController::class, 'showUpdateUser'])->name('show.update.user');
    Route::put('/users/update/{id}', [EmployeeUserController::class, 'update'])->name('update.user');
    //end users route

    //start project routes
    Route::get('/projects/create/{step}', [EmployeeProjectController::class, 'index'])->name('new.project.show');
    Route::post('/projects/create/{step}', [EmployeeProjectController::class, 'create'])->name('create.project');
    Route::post('/projects/create', [EmployeeProjectController::class, 'finalCreateProject'])->name('create.project.final');

    Route::get('/projects/update/{step}/{id}', [EmployeeProjectController::class, 'updateShow'])->name('update.project.show');
    Route::post('/projects/update/{step}/{id}', [EmployeeProjectController::class, 'update'])->name('update.project');
    Route::post('/projects/update', [EmployeeProjectController::class, 'finalUpdateProject'])->name('update.project.final');

    Route::get('/project/{id}', [EmployeeProjectController::class, 'show'])->name('show.project');
    Route::delete('/project/{id}', [EmployeeProjectController::class, 'destroy'])->name('delete.project');
    //end project routes
});
// end employee route