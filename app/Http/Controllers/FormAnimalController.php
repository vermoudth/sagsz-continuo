<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class FormAnimalController extends Controller
{
    // Mostrar el formulario de registro de animales
    public function create()
    {
        return view('interfaces.animal');
    }

    // Mostrar la lista de animales
    public function index()
    {
        $animales = Animal::all(); // Obtiene todos los registros de la tabla 'animales'
        return view('interfaces.panelAnimal', compact('animales'));
    }

    // Guardar un nuevo animal
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'especie' => 'required|string|max:255',
                'raza' => 'nullable|string|max:255',
                'edad' => 'nullable|integer|min:0',
                'peso' => 'nullable|numeric|min:0',
                'ubicacion' => 'nullable|string|max:255',
                'cuidador_id' => 'nullable|integer|exists:users,id',
                'fecha_registro' => 'nullable|date',
            ]);

            $animal = Animal::create($validatedData);
            
            return response()->json(['message' => 'Animal registrado con éxito.', 'animal' => $animal], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Datos inválidos', 'details' => $e->errors()], 422);
        }
    }

    // Eliminar un animal
    public function destroy($id)
    {
        try {
            $animal = Animal::findOrFail($id);
            $animal->delete();

            return response()->json(['message' => 'Animal eliminado correctamente.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Animal no encontrado'], 404);
        }
    }

    // Obtener datos de animales en formato JSON
    public function getAnimalesData()
    {
        $animales = Animal::with('cuidador:id,name')->get(['id', 'nombre', 'especie', 'raza', 'edad', 'peso', 'ubicacion', 'cuidador_id', 'fecha_registro']);
        return response()->json($animales);
    }
}
