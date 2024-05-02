<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

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