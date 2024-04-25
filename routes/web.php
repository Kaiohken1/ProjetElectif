<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppartementController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\AppartementImageController;
use App\Models\Appartement;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('appart', AppartementController::class)->except(['index']);
    Route::resource('tag', TagController::class);
    Route::get('/dashboard', [AppartementController::class, 'userIndex'])->name('dashboard');

    Route::delete('/appartimage/{id}', [AppartementController::class, 'destroyImg'])->name('appart.destroyImg');

    Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation');
    Route::get('/reservation/{id}/edit', [ReservationController::class, 'edit'])->name('reservation.edit');
    Route::get('reservation/create/{appartement_id}', [ReservationController::class, 'create'])->name('reservation.create');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservation.index');
    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
    Route::patch('/reservation/validate/{id}', [ReservationController::class, 'validate'])->name('reservation.validate');
    Route::patch('/reservation/refused/{id}', [ReservationController::class, 'refused'])->name('reservation.refused');
    Route::get('/reservation/{id}', [ReservationController::class, 'showAll'])->name('reservation.showAll');
    Route::resource('notifcations', NotificationsController::class);
    Route::post('/reservation/{id}/cancel', [ReservationController::class, 'destroy'])->name('reservation.cancel');

});

Route::get('/', [AppartementController::class, 'index'])->name('appart.index');

require __DIR__ . '/auth.php';
