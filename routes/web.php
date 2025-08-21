<?php
// routes/web.php

use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SurveyController::class, 'index'])->name('survey.index');
Route::post('/survey', [SurveyController::class, 'store'])->name('survey.store');
Route::get('/dashboard', [SurveyController::class, 'dashboard'])->name('survey.dashboard');
Route::get('/export', [SurveyController::class, 'export'])->name('survey.export');