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
        $animales = Animal::all();
        $usuarios = User::all();
        $categorias = CategoriaAnimal::all();
        $categoriaId = $request->input('categoria_id');

        $nutriciones = Nutricion::with(['animal.categoria', 'responsable'])->paginate(3);

        if ($request->ajax()) {
            return view('interfaces.nutricionPanel', compact('usuarios', 'animales', 'nutriciones', 'categorias'));
        } else {
            return view('interfaces.homePanel', [
                'modulo' => 'nutricion',
                'usuarios' => $usuarios,
                'animales' => $animales,
                'nutriciones' => $nutriciones,
                'categorias' => $categorias,
            ]);
        }
    }


    // Guardar una nueva nutrición
    public function store(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animales,id',
            'dieta' => 'required|string',
            'cantidad' => 'required|string',
            'fecha' => 'required|date',
            'responsable_id' => 'required|exists:usuarios,id'
        ]);

        Nutricion::create($request->all());

        return redirect()->route('nutricion.index')->with('success', 'Registro de nutrición agregado exitosamente.');
    }

    // Actualizar una nutrición existente
    public function update(Request $request, $id)
    {
        $nutricion = Nutricion::findOrFail($id);
        $nutricion->animal_id = $request->animal_id;
        $nutricion->dieta = $request->dieta;
        $nutricion->cantidad = $request->cantidad;
        $nutricion->fecha = $request->fecha;
        $nutricion->responsable_id = $request->responsable_id;
        $nutricion->save();

        return redirect()->route('nutricion.index')->with('success', 'Registro actualizado correctamente');

    }

    // Eliminar una nutrición
    public function destroy($id)
    {
        try {
            $nutricion = Nutricion::findOrFail($id);
            $nutricion->delete();

            return redirect()->route('nutricion.index')->with('success', 'Registro de nutrición eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('nutricion.index')->with('error', 'Error al eliminar el registro de nutrición.');
        }
    }
}
