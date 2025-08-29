<?php
// routes/web.php

use App\Http\Controllers\SurveyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SurveyQuestionController;
use App\Http\Controllers\DynamicSurveyController;
use Illuminate\Support\Facades\Route;

// Public Survey Routes
Route::get('/', [SurveyController::class, 'index'])->name('survey.index');
Route::post('/survey', [SurveyController::class, 'store'])->name('survey.store');
Route::get('/dashboard', [SurveyController::class, 'dashboard'])->name('survey.dashboard');
Route::get('/export', [SurveyController::class, 'export'])->name('survey.export');

// Admin Authentication Routes
Route::get('/admin', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/auth', [AdminController::class, 'authenticate'])->name('admin.authenticate');
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Admin Dashboard & Management Routes - UPDATED untuk mendukung tab parameter
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');
Route::delete('/admin/survey/{id}', [AdminController::class, 'deleteSurvey'])->name('admin.deleteSurvey');

// Admin Question Management Routes
Route::prefix('admin/questions')->name('admin.questions.')->group(function () {
    // Main questions page
    Route::get('/', [SurveyQuestionController::class, 'index'])->name('index');
    
    // Section management
    Route::get('/section/create', [SurveyQuestionController::class, 'createSection'])->name('create-section');
    Route::post('/section', [SurveyQuestionController::class, 'storeSection'])->name('store-section');
    Route::delete('/section/{id}', [SurveyQuestionController::class, 'deleteSection'])->name('delete-section');
    Route::put('/section/{id}/toggle', [SurveyQuestionController::class, 'toggleSection'])->name('toggle-section');
    Route::post('/sections/reorder', [SurveyQuestionController::class, 'updateSectionOrder'])->name('reorder-sections');
    
    // Question management
    Route::get('/section/{sectionId}/question/create', [SurveyQuestionController::class, 'createQuestion'])->name('create-question');
    Route::post('/section/{sectionId}/question', [SurveyQuestionController::class, 'storeQuestion'])->name('store-question');
    Route::get('/question/{id}/edit', [SurveyQuestionController::class, 'editQuestion'])->name('edit-question');
    Route::put('/question/{id}', [SurveyQuestionController::class, 'updateQuestion'])->name('update-question');
    Route::delete('/question/{id}', [SurveyQuestionController::class, 'deleteQuestion'])->name('delete-question');
    Route::put('/question/{id}/toggle', [SurveyQuestionController::class, 'toggleQuestion'])->name('toggle-question');
    Route::post('/section/{sectionId}/questions/reorder', [SurveyQuestionController::class, 'updateQuestionOrder'])->name('reorder-questions');
});

Route::get('/admin/survey/{id}/detail', [AdminController::class, 'getSurveyDetail'])->name('admin.surveyDetail');

// Dynamic Survey Routes (Optional - for future use if needed)
Route::get('/dynamic-survey', [DynamicSurveyController::class, 'index'])->name('dynamic-survey.index');
Route::post('/dynamic-survey', [DynamicSurveyController::class, 'store'])->name('dynamic-survey.store');
Route::get('/dynamic-survey/preview', [DynamicSurveyController::class, 'preview'])->name('dynamic-survey.preview');
Route::get('/dynamic-survey/structure', [DynamicSurveyController::class, 'getStructure'])->name('dynamic-survey.structure');
Route::get('/dynamic-survey/stats', [DynamicSurveyController::class, 'getStats'])->name('dynamic-survey.stats');
Route::get('/dynamic-survey/export', [DynamicSurveyController::class, 'export'])->name('dynamic-survey.export');
Route::get('/dynamic-survey/download/{responseId}', [DynamicSurveyController::class, 'downloadFile'])->name('dynamic-survey.download');