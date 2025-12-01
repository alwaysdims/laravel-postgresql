<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [\App\Http\Controllers\AuthController::class,'loginForm'])->name('loginForm');
Route::post('/login', [\App\Http\Controllers\AuthController::class,'login'])->name('login');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\AuthController::class,'logout'])->name('logout');
});

Route::middleware('auth')->group(function(){
    Route::resource('data-admins', \App\Http\Controllers\Admin\AdminController::class)->names('data.admins');
    Route::resource('data-students', \App\Http\Controllers\Admin\StudentController::class)->names('data.students');
    Route::resource('data-teachers', \App\Http\Controllers\Admin\TeacherController::class)->names('data.teachers');
});

Route::middleware('auth')->group(function(){
    Route::get('dashboard',[\App\Http\Controllers\Student\DashboardController::class,'index'])->name('student.dashboard');
});
Route::middleware('auth')->group(function(){
    Route::get('dashboard',[\App\Http\Controllers\Teacher\DashboardController::class,'index'])->name('teacher.dashboard');
});
