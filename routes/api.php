<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MonitoreoAmbientalController;

Route::post('/registros-ambientales', [MonitoreoAmbientalController::class, 'guardar']);
Route::get('/registros-ambientales-ultimos', [MonitoreoAmbientalController::class, 'obtenerUltimos']);
/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/