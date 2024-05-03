<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LendingBookController;
use App\Http\Controllers\UserController;
use App\Models\Author;
use App\Models\Book;
use App\Models\LendingBook;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware('jwtAuth:api')->group(function() {
    Route::prefix('auth')->group(function() {
        Route::post('login', [AuthController::class, 'login'])
            ->withoutMiddleware('jwtAuth:api')
            ->name('auth.login');
    });

    Route::prefix('user')->group(function() {
        Route::get('', [UserController::class, 'index'])
            ->can('view', User::class)
            ->name('user.index');

        Route::post('', [UserController::class, 'store'])
            ->withoutMiddleware('jwtAuth:api')
            ->name('user.store');
    });
    
    Route::prefix('author')->group(function() {
        Route::get('', [AuthorController::class, 'index'])
            ->can('view', Author::class)
            ->name('author.index');

        Route::post('', [AuthorController::class, 'store'])
            ->can('create', Author::class)
            ->name('author.store');

        Route::put('{author}', [AuthorController::class, 'update'])
            ->can('update', Author::class)
            ->name('author.update');

        Route::delete('{id}', [AuthorController::class, 'destroy'])
            ->can('delete', Author::class)
            ->name('author.destroy');
    });
    
    Route::prefix('book')->group(function() {
        Route::get('', [BookController::class, 'index'])
            ->can('view', Book::class)
            ->name('book.index');

        Route::post('', [BookController::class, 'store'])
            ->can('create', Book::class)
            ->name('book.store');

        Route::put('{book}', [BookController::class, 'update'])
            ->can('update', Book::class)
            ->name('book.update');

        Route::delete('{id}', [BookController::class, 'destroy'])
            ->can('delete', Book::class)
            ->name('book.destroy');
    });
    
    Route::prefix('lending_book')->group(function() {
        Route::get('', [LendingBookController::class, 'index'])
            ->can('view', LendingBook::class)
            ->name('lendingBook.index');

        Route::post('', [LendingBookController::class, 'store'])
            ->can('create', LendingBook::class)
            ->name('lendingBook.store');
    });
});
