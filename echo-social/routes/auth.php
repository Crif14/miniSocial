<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

// Queste rotte sono accessibili solo se l'utente non ha ancora effettuato il login
Route::middleware('guest')->group(function () {

    // Registrazione: Visualizzazione del form e salvataggio nuovo utente
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    // Login: Visualizzazione del form e creazione della sessione
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Queste rotte sono accessibili solo dopo che l'utente ha effettuato l'accesso
Route::middleware('auth')->group(function () {

    // Logout: Distruzione della sessione corrente
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});