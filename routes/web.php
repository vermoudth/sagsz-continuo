<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\HomePanelController;
use App\Http\Controllers\LogInController;
use App\Http\Controllers\FormAnimalController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/register', [RegistrationController::class, 'show'])->name('auth.register');
Route::post('/register', [RegistrationController::class, 'register'])->name('auth.register');

Route::get('/login', [LogInController::class, 'show'])->name('auth.login');
Route::post('/login', [LogInController::class, 'login'])->name('auth.login');

Route::post('/logout', [LogInController::class, 'logout'])->name('logout');

Route::get('/homePanel', [HomePanelController::class, 'index'])->name('homePanel');

// Rutas para el manejo de animales
Route::get('/animal', [FormAnimalController::class, 'create'])->name('animal.create');
Route::post('/animal', [FormAnimalController::class, 'store'])->name('animal.store');

// Ruta para mostrar la lista de animales
Route::get('/animales', [FormAnimalController::class, 'index'])->name('panel.animales');
Route::get('/animales/data', [FormAnimalController::class, 'getAnimalesData'])->name('animales.data');


// Ruta para eliminar un animal
Route::delete('/animales/{id}', [FormAnimalController::class, 'destroy'])->name('animal.destroy');
