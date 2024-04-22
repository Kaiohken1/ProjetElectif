<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppartementController;
use App\Http\Controllers\AppartementImageController;


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('appart', AppartementController::class)->except(['index']);
    Route::get('/dashboard', [AppartementController::class, 'userIndex'])->name('dashboard');

    Route::delete('/appart-image/{id}', [AppartementImageController::class, 'destroy'])->name('appart.image.delete');


});

Route::get('/', [AppartementController::class, 'index'])->name('appart.index');

require __DIR__ . '/auth.php';
