<?php
// routes/web.php

use App\Http\Controllers\SurveyController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SurveyController::class, 'index'])->name('survey.index');
Route::post('/survey', [SurveyController::class, 'store'])->name('survey.store');
Route::get('/dashboard', [SurveyController::class, 'dashboard'])->name('survey.dashboard');
Route::get('/export', [SurveyController::class, 'export'])->name('survey.export');

// Admin routes - tanpa prefix agar bisa diakses langsung
Route::get('/admin', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/auth', [AdminController::class, 'authenticate'])->name('admin.authenticate');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');
Route::delete('/admin/survey/{id}', [AdminController::class, 'deleteSurvey'])->name('admin.deleteSurvey');
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');