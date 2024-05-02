<?php

use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;

Route::prefix('author')->group(function() {
    Route::get('', [AuthorController::class, 'index'])->name('author.index');
    Route::post('', [AuthorController::class, 'store'])->name('author.store');
    Route::put('{author}', [AuthorController::class, 'update'])->name('author.update');
    Route::delete('{id}', [AuthorController::class, 'destroy'])->name('author.destroy');
});
