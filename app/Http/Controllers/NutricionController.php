<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nutricion;
use App\Models\Animal;
use App\Models\User;
use App\Models\CategoriaAnimal;

class NutricionController extends Controller
{
    // Mostrar todas las crianzas
    public function index(Request $request)
    {
        return view('interfaces.nutricionPanel');
        $animales = Animal::all();
        $usuarios = User::all();
        $categorias = CategoriaAnimal::all();
        $categoriaId = $request->input('categoria_id');

        $nutricion = Nutricion::with(['animal.categoria', 'responsable'])->paginate(3);

        if ($request->ajax()) {
            return view('interfaces.nutricionPanel', compact('usuarios', 'animales', 'crianzas', 'categorias'));
        } else {
            return view('interfaces.homePanel', [
                'modulo' => 'nutricion',
                'usuarios' => $usuarios,
                'animales' => $animales,
                'nurticion' => $nutricion,
                'categorias' => $categorias,
            ]);
        }
    }


    public function store(Request $request)
    {
        // Validación y guardado según tus campos en crianza
    }


    public function update(Request $request, $id)
    {
        // Lógica para actualizar crianza
    }

    public function destroy($id)
    {
        // Lógica para eliminar crianza
    }
}
