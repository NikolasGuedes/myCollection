<?php

use App\Http\Controllers\mainController;
use App\Http\Controllers\CollectionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [mainController::class, 'index'])->name('home');
Route::get('/collection', [mainController::class, 'collection'])->name('collection');
Route::get('/friends', [mainController::class, 'friends'])->name('friends');
Route::get('/comments', [mainController::class, 'comments'])->name('comments');

Route::prefix('collection')->middleware('auth')->group(function () {
    Route::post('/', [CollectionController::class, 'store'])->name('collection.store');
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
