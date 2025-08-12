<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
            ->join('parametros_ambientales', 'registros_ambientales.categoria_id', '=', 'parametros_ambientales.categoria_id')
            ->join('categorias_animales', 'registros_ambientales.categoria_id', '=', 'categorias_animales.id')
            ->select(
                'registros_ambientales.*',
                'categorias_animales.nombre as categoria_nombre',
                'parametros_ambientales.temperatura_min',
                'parametros_ambientales.temperatura_max',
                'parametros_ambientales.humedad_min',
                'parametros_ambientales.humedad_max'
            )
            ->get();

        return response()->json($datos);
    }



    public function guardar(Request $request)
    {
        $validated = $request->validate([
            'categoria_id' => 'required|integer|exists:categorias_animales,id',
            'temperatura' => 'required|numeric',
            'humedad' => 'required|numeric',
        ]);

        \App\Models\RegistroAmbiental::create([
            'categoria_id' => $validated['categoria_id'],
            'temperatura' => $validated['temperatura'],
            'humedad' => $validated['humedad'],
            'registrado_en' => now(),
        ]);

        return response()->json(['success' => true], 201);
    }


}
