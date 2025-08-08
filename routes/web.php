<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\HomePanelController;
use App\Http\Controllers\FormAnimalController;
use App\Http\Controllers\CrianzaController;
use App\Http\Controllers\API\MonitoreoAmbientalController;
use App\Http\Controllers\TrasladosController;
use App\Http\Controllers\LaboratorioController;


/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------
*/
Route::get('/', [IndexController::class, 'index'])->name('index');
Route::post('/login', [IndexController::class, 'login'])->name('login');
Route::post('/logout', [IndexController::class, 'logout'])->name('logout');

Route::get('/register', [RegistrationController::class, 'show'])->name('auth.register');
Route::post('/register', [RegistrationController::class, 'register'])->name('auth.register');

/*
|--------------------------------------------------------------------------
| Panel Principal
|--------------------------------------------------------------------------
*/
Route::get('/homePanel', [HomePanelController::class, 'index'])->name('homePanel');

/*
|--------------------------------------------------------------------------
| Módulo de Crianza
|--------------------------------------------------------------------------
*/
Route::prefix('crianza')->group(function () {
    Route::get('/', [CrianzaController::class, 'index'])->name('crianza.index');
    Route::post('/', [CrianzaController::class, 'store'])->name('crianza.store');
    Route::put('/{id}', [CrianzaController::class, 'update'])->name('crianza.update');
    Route::delete('/{id}', [CrianzaController::class, 'destroy'])->name('crianza.destroy');
});

Route::get('/filtrar-crianza', [CrianzaController::class, 'filtrar'])->name('filtrar.crianza');

/*
|--------------------------------------------------------------------------
| Módulo de Laboratorio
|--------------------------------------------------------------------------
*/
Route::prefix('laboratorio')->group(function () {
    Route::get('/', [LaboratorioController::class, 'index'])->name('laboratorio.index');
    Route::post('/', [LaboratorioController::class, 'store'])->name('laboratorio.store');
    Route::put('/{id}', [LaboratorioController::class, 'update'])->name('laboratorio.update');
    Route::delete('/{id}', [LaboratorioController::class, 'destroy'])->name('laboratorio.destroy');
});

/*
|--------------------------------------------------------------------------
| Módulo de Animales
|--------------------------------------------------------------------------
*/
Route::get('/animal', [FormAnimalController::class, 'create'])->name('animal.create');
Route::post('/animal', [FormAnimalController::class, 'store'])->name('animal.store');
Route::get('/animales', [FormAnimalController::class, 'index'])->name('panel.animales');
Route::get('/animales/data', [FormAnimalController::class, 'getAnimalesData'])->name('animales.data');
Route::delete('/animales/{id}', [FormAnimalController::class, 'destroy'])->name('animal.destroy');

/*
|--------------------------------------------------------------------------
| Panel de Traslados
|--------------------------------------------------------------------------
*/
//Route::get('/traslados', [TrasladosController::class, 'index'])->name('traslados.index');

Route::prefix('traslados')->group(function () {
    Route::get('/', [TrasladosController::class, 'index'])->name('traslados.index');
    //Route::post('/', [TrasladosController::class, 'store'])->name('traslados.store');
    //  Route::put('/{id}', [TrasladosController::class, 'update'])->name('traslados.update');
   // Route::delete('/{id}', [TrasladosController::class, 'destroy'])->name('traslados.destroy');
});

/*
|--------------------------------------------------------------------------
| Módulo de Monitorización Ambiental
|--------------------------------------------------------------------------
*/
Route::get('/monitoreo-ambiental', [MonitoreoAmbientalController::class, 'index']);


/*
|--------------------------------------------------------------------------
| Test y fallback
|--------------------------------------------------------------------------
*/
Route::get('/test-503', function () {
    abort(503);
});

// Fallback SPA: redirige cualquier otra ruta a homePanel
Route::get('/{any}', function () {
    return redirect('/homePanel');
})->where('any', '.*');
