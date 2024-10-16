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
// end auth routes

//start forgot password route
Route::get('/forgot-password', [ForgotPasswordController::class, 'Index'])->name('forgot.password');
Route::post('/forgot-password-post', [ForgotPasswordController::class, 'submitForgotPasswordForm'])->name('forgot.password.post');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.form');
Route::post('/reset-password-post', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
//start forgot password route

// start role route
Route::group(['middleware' => 'role'], function () {
    Route::get('/admin/panel', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/employee/panel', [EmployeeController::class, 'index'])->name('employee.dashboard');
});
// end role route



Route::get('/', [ProjectsController::class, 'index'])->name('home');
Route::get('/tech-projects/{id}', [ProjectsController::class, 'techProjects'])->name('tech');
