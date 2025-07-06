<?php

use App\Http\Controllers\mainController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [mainController::class, 'index'])->name('home');
Route::get('/collection', [mainController::class, 'collection'])->name('collection');
Route::get('/friends', [mainController::class, 'friends'])->name('friends');
Route::get('/comments', [mainController::class, 'comments'])->name('comments');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
