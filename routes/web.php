<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SpeakerController;

// Rute Tamu
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Rute yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Index & Create & Update (Bisa diakses Admin dan Staff)
    Route::get('/speakers', [SpeakerController::class, 'index'])->name('speakers.index');
    Route::post('/speakers', [SpeakerController::class, 'store'])->name('speakers.store');
    Route::put('/speakers/{id}', [SpeakerController::class, 'update'])->name('speakers.update');

    // Delete (KHUSUS ADMIN)
    Route::delete('/speakers/{id}', [SpeakerController::class, 'destroy'])
        ->name('speakers.destroy')
        ->middleware('role:admin'); // Hanya role admin yang bisa lewat sini
});