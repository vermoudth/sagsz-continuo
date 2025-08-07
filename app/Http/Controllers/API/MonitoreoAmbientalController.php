<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RegistroAmbiental;
use App\Models\CategoriaAnimal;

class MonitoreoAmbientalController extends Controller
{
    public function index(Request $request)
    {
        $categorias = CategoriaAnimal::all();

        return $request->ajax()
            ? view('interfaces.monitoreoAmbientalPanel', compact('categorias'))
            : view('interfaces.homePanel', [
                'modulo' => 'monitoreoAmbiental',
                'categorias' => $categorias,
            ]);
    }

    // Endpoint para traer los últimos registros por categoría (para fetch)
    public function obtenerUltimos()
    {
        $ultimos = RegistroAmbiental::select('categoria_id')
            ->selectRaw('MAX(registrado_en) as max_fecha')
            ->groupBy('categoria_id');

        $datos = RegistroAmbiental::joinSub($ultimos, 'ultimos', function ($join) {
                $join->on('registros_ambientales.categoria_id', '=', 'ultimos.categoria_id')
                    ->on('registros_ambientales.registrado_en', '=', 'ultimos.max_fecha');
            })
            ->with('categoria') // Relación con nombre de categoría
            ->get();

        return response()->json($datos);
    }

}
