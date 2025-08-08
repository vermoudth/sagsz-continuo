<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laboratorio;
use App\Models\Animal;
use App\Models\User;
use App\Models\CategoriaAnimal;

class LaboratorioController extends Controller
{
    public function index(Request $request)
    {
        $animales = Animal::all();
        $usuarios = User::all();
        $categorias = CategoriaAnimal::all();

        $categoriaId = $request->input('categoria_id');

        $laboratorios = Laboratorio::with(['animal.categoria', 'responsable'])->paginate(3);

        if ($request->ajax()) {
            return view('interfaces.laboratorioPanel', compact('usuarios', 'animales', 'laboratorios', 'categorias'));
        } else {
            return view('interfaces.homePanel', [
                'modulo' => 'laboratorio',
                'usuarios' => $usuarios,
                'animales' => $animales,
                'laboratorios' => $laboratorios,
                'categorias' => $categorias,
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animales,id',
            'diagnostico' => 'required|string',
            'tratamiento' => 'required|string',
            'fecha' => 'required|date',
            'responsable_id' => 'required|exists:usuarios,id',
        ]);

        Laboratorio::create($request->all());

        return redirect()->route('laboratorio.index')->with('success', 'Registro de laboratorio agregado exitosamente.');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'animal_id' => 'required|exists:animales,id',
            'diagnostico' => 'required|string',
            'tratamiento' => 'required|string',
            'fecha' => 'required|date',
            'responsable_id' => 'required|exists:usuarios,id',
        ]);

        $laboratorio = Laboratorio::findOrFail($id);
        $laboratorio->animal_id = $request->animal_id;
        $laboratorio->diagnostico = $request->diagnostico;
        $laboratorio->tratamiento = $request->tratamiento;
        $laboratorio->fecha = $request->fecha;
        $laboratorio->responsable_id = $request->responsable_id;
        $laboratorio->save();

        return redirect()->route('laboratorio.index')->with('success', 'Registro actualizado correctamente');
    }

    public function destroy($id)
    {
        try {
            $laboratorio = Laboratorio::findOrFail($id);
            $laboratorio->delete();

            return redirect()->route('laboratorio.index')->with('success', 'Registro de laboratorio eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('laboratorio.index')->with('error', 'Error al eliminar el registro de laboratorio.');
        }
    }

    public function filtrar(Request $request)
    {
        $categoria = $request->categoria;
        $laboratorios = Laboratorio::whereHas('animal', function ($query) use ($categoria) {
            $query->where('categoria', $categoria);
        })->with(['animal', 'responsable'])->get();

        return view('partials.laboratorioCards', compact('laboratorios'));
    }
}
