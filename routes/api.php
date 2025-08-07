<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MonitoreoAmbientalController;

Route::get('/ultimos-registros-ambientales', [MonitoreoAmbientalController::class, 'obtenerUltimos']);

