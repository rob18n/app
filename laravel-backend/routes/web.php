<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectLanguageKeyController;
use App\Http\Controllers\ProjectLanguageKeyValueController;
use Illuminate\Support\Facades\Route;

Route::apiResource('projects', ProjectController::class);
Route::apiResource('languages', LanguageController::class);
Route::apiResource('project-languages-key', ProjectLanguageKeyController::class);
Route::apiResource('project-languages-key-value', ProjectLanguageKeyValueController::class);
