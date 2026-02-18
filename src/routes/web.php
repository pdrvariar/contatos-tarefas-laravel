<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\TaskController;
use App\Http\Controllers\Web\BookController;
use App\Http\Controllers\Web\ProfileController;
use App\Livewire\Book\Index as BookIndex;
use App\Livewire\Book\Create as BookCreate;
use App\Livewire\Book\Edit as BookEdit;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Auth::check() ? redirect('/contacts') : redirect('/login');
});

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {
    // Rotas principais que carregam as Views
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

    // CRUD de Books com Livewire
    Route::get('/books', BookIndex::class)->name('books.index');
    Route::get('/books/create', BookCreate::class)->name('books.create');
    Route::get('/books/{book}/edit', BookEdit::class)->name('books.edit');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show'); // Mantém o show tradicional ou migra depois

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Rotas internas para o frontend (AJAX)
    // Usamos o prefixo 'web-api' e o nome 'web-api.' para evitar conflito com as rotas da API pública
    Route::prefix('web-api')->as('web-api.')->group(function () {
        Route::apiResource('contacts', \App\Http\Controllers\Api\v1\ContactController::class);
        Route::patch('tasks/{task}/complete', [\App\Http\Controllers\Api\v1\TaskController::class, 'complete'])->name('tasks.complete');
        Route::apiResource('tasks', \App\Http\Controllers\Api\v1\TaskController::class);
        Route::apiResource('books', \App\Http\Controllers\Api\v1\BookController::class);
        Route::get('tags', [\App\Http\Controllers\Api\v1\TagController::class, 'index'])->name('tags.index');
    });
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout.custom');
