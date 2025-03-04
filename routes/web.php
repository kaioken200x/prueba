<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('users', UserController::class);

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');

    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks', [TaskController::class, 'report'])->name('tasks.report');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
