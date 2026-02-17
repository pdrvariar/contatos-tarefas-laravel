<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\ContactController;
use App\Http\Controllers\Api\v1\TaskController;
use App\Http\Controllers\Api\v1\BookController;
use App\Http\Controllers\Api\v1\TagController;
use App\Http\Controllers\Api\v1\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes - Version 1
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->as('api.')->group(function () {
    // Auth
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);

        // Contacts
        Route::apiResource('contacts', ContactController::class);

        // Tasks
        Route::patch('tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
        Route::apiResource('tasks', TaskController::class);

        // Books
        Route::apiResource('books', BookController::class);

        // Tags (Autocomplete)
        Route::get('tags', [TagController::class, 'index'])->name('tags.index');
    });
});
