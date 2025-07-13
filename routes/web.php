<?php

use App\Http\Controllers\mainController;
use App\Http\Controllers\CollectionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [mainController::class, 'index'])->name('home');
Route::get('/friends', [mainController::class, 'friends'])->name('friends');//chamar na propria controller
Route::get('/comments', [mainController::class, 'comments'])->name('comments');//chamar na propria controller

Route::prefix('collection')->middleware('auth')->group(function () {
    Route::get('/', [CollectionController::class, 'index'])->middleware('auth')->name('collection');
    Route::post('/', [CollectionController::class, 'store'])->name('collection.store');
    Route::delete('/{id}', [CollectionController::class, 'destroy'])->name('collection.destroy');
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
