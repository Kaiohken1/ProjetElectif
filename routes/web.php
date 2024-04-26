<?php

use App\Http\Controllers\AppartementController;
use App\Http\Controllers\FermetureController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
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
    Route::resource('fermeture', FermetureController::class)->except(['index']);
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

    Route::prefix('appartement/{appartement}/edit')->group(function () {
        Route::get('/fermetures', [FermetureController::class, 'index'])->name('fermeture.index');
        Route::delete('/fermetures/{fermeture}', [FermetureController::class, 'destroy'])->name('fermeture.destroy');
        Route::patch('/fermetures/{fermeture}', [FermetureController::class, 'update'])->name('fermeture.update');
        Route::get('/fermetures/create', [FermetureController::class, 'create'])->name('fermeture.create');
        Route::post('/fermetures', [FermetureController::class, 'store'])->name('fermeture.store');
    });

    Route::resource('notifcations', NotificationsController::class);
    Route::post('/reservation/{id}/cancel', [ReservationController::class, 'destroy'])->name('reservation.cancel');

});

Route::get('/', [AppartementController::class, 'index'])->name('appart.index');


require __DIR__ . '/auth.php';
