<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectLanguageKeyController;
use App\Http\Controllers\ProjectLanguageKeyValueController;
use App\Http\Controllers\LanguageKeyImportController;
use App\Http\Controllers\LanguageKeyExportController;
use App\Http\Controllers\UpdateController;
use Illuminate\Support\Facades\Route;

Route::apiResource('projects', ProjectController::class);
Route::post('projects/add-language', [ProjectController::class, 'addLanguage']);
Route::post('projects/destroy-language', [ProjectController::class, 'destroyLanguage']);

Route::apiResource('languages', LanguageController::class);

Route::apiResource('project-languages-key', ProjectLanguageKeyController::class);

Route::apiResource('project-languages-key-value', ProjectLanguageKeyValueController::class);

Route::post('language-key/import', [LanguageKeyImportController::class, 'upload']);
Route::post('language-key/export', [LanguageKeyExportController::class, 'export']);

Route::get('update/check', [UpdateController::class, 'checkUpdates']);
