<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;

Route::get('/', [ProjectsController::class, 'index']);
Route::get('/tech-projects/{id}', [ProjectsController::class, 'techProjects'])->name('tech');
?>