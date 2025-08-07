<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MonitoreoAmbientalController;

//Route::get('/ultimos-registros-ambientales', [MonitoreoAmbientalController::class, 'obtenerUltimos']);
Route::post('/registros-ambientales', [MonitoreoAmbientalController::class, 'guardar']);
Route::get('/test', function () {
    return response()->json(['message' => 'Todo bien desde el API!']);
});
