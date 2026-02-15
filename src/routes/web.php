<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\TaskController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Auth::check() ? redirect('/contacts') : redirect('/login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    // Rotas principais que carregam as Views
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

    // Rotas internas para o frontend (AJAX)
    // Usamos o prefixo 'web-api' e o nome 'web-api.' para evitar conflito com as rotas da API pública
    Route::prefix('web-api')->as('web-api.')->group(function () {
        Route::apiResource('contacts', \App\Http\Controllers\Api\v1\ContactController::class);
        Route::patch('tasks/{task}/complete', [\App\Http\Controllers\Api\v1\TaskController::class, 'complete'])->name('tasks.complete');
        Route::apiResource('tasks', \App\Http\Controllers\Api\v1\TaskController::class);
        Route::get('tags', [\App\Http\Controllers\Api\v1\TagController::class, 'index'])->name('tags.index');
    });
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout.custom');
