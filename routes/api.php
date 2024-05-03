<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LendingBookController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\JWTAuth;
use Illuminate\Support\Facades\Route;

Route::middleware([JWTAuth::class])->group(function() {
    Route::prefix('auth')->group(function() {
        Route::post('login', [AuthController::class, 'login'])->name('auth.login')->withoutMiddleware([JWTAuth::class]);
    });

    Route::prefix('user')->group(function() {
        Route::get('', [UserController::class, 'index'])->name('user.index');
        Route::post('', [UserController::class, 'store'])->name('user.store')->withoutMiddleware([JWTAuth::class]);
    });
    
    Route::prefix('author')->group(function() {
        Route::get('', [AuthorController::class, 'index'])->name('author.index');
        Route::post('', [AuthorController::class, 'store'])->name('author.store');
        Route::put('{author}', [AuthorController::class, 'update'])->name('author.update');
        Route::delete('{id}', [AuthorController::class, 'destroy'])->name('author.destroy');
    });
    
    Route::prefix('book')->group(function() {
        Route::get('', [BookController::class, 'index'])->name('book.index');
        Route::post('', [BookController::class, 'store'])->name('book.store');
        Route::put('{book}', [BookController::class, 'update'])->name('book.update');
        Route::delete('{id}', [BookController::class, 'destroy'])->name('book.destroy');
    });
    
    Route::prefix('lending_book')->group(function() {
        Route::get('', [LendingBookController::class, 'index'])->name('lendingBook.index');
        Route::post('', [LendingBookController::class, 'store'])->name('lendingBook.store');
    });
});
