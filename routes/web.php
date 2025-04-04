<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\HomePanelController;
use App\Http\Controllers\FormAnimalController;
use App\Http\Controllers\TrasladosController;
use App\Http\Controllers\CrianzaController;

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::post('/login', [IndexController::class, 'login'])->name('login');
Route::post('/logout', [IndexController::class, 'logout'])->name('logout');

Route::get('/register', [RegistrationController::class, 'show'])->name('auth.register');
Route::post('/register', [RegistrationController::class, 'register'])->name('auth.register');

Route::get('/homePanel', [HomePanelController::class, 'index'])->name('homePanel');

//Rutas de Panel de Crianza
Route::get('/crianza', [CrianzaController::class, 'index'])->name('crianza.index');
Route::get('/crianza/create', [CrianzaController::class, 'create'])->name('crianza.create');
Route::post('/crianza', [CrianzaController::class, 'store'])->name('crianza.store');
Route::get('/crianza/{id}', [CrianzaController::class, 'show'])->name('crianza.show');
Route::get('/crianza/{id}/edit', [CrianzaController::class, 'edit'])->name('crianza.edit');
Route::put('/crianza/{id}', [CrianzaController::class, 'update'])->name('crianza.update');
Route::delete('/crianza/{id}', [CrianzaController::class, 'destroy'])->name('crianza.destroy');

// Rutas para el manejo de animales
Route::get('/animal', [FormAnimalController::class, 'create'])->name('animal.create');
Route::post('/animal', [FormAnimalController::class, 'store'])->name('animal.store');

// Ruta para mostrar la lista de animales
Route::get('/animales', [FormAnimalController::class, 'index'])->name('panel.animales');
Route::get('/animales/data', [FormAnimalController::class, 'getAnimalesData'])->name('animales.data');


// Ruta para eliminar un animal
Route::delete('/animales/{id}', [FormAnimalController::class, 'destroy'])->name('animal.destroy');

//Ruta para Panel de Traslados
Route::get('/trasladosPanel', [TrasladosController::class, 'index'])->name('trasladosPanel');

Route::get('/test-503', function () {
  abort(503);
});
