<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\HomePanelController;
use App\Http\Controllers\FormAnimalController;
use App\Http\Controllers\CrianzaController;
use App\Http\Controllers\NutricionController;

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
| Módulo de Nutrición
|--------------------------------------------------------------------------
*/
Route::prefix('nutricion')->group(function () {
    Route::get('/', [NutricionController::class, 'index'])->name('nutricion.index');
    //Route::post('/', [NutricionController::class, 'store'])->name('nutricion.store');
    //Route::put('/{id}', [NutricionController::class, 'update'])->name('nutricion.update');
    //Route::delete('/{id}', [NutricionController::class, 'destroy'])->name('nutricion.destroy');
});


/*
|--------------------------------------------------------------------------
| Panel de Traslados (SPA compatible)
|--------------------------------------------------------------------------
*/
Route::get('/trasladosPanel', function () {
    if (request()->ajax()) {
        return view('interfaces.trasladosPanel');
    }
    return redirect('/homePanel');
})->name('trasladosPanel');

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
