<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Traslados;
use App\Models\Animal;
use App\Models\User;

class TrasladosController extends Controller
{
    // Mostrar todos los traslados
    public function index(Request $request)
    {
        $animales = Animal::all();
        $usuarios = User::all();
        $traslados = Traslados::with(['animal', 'responsable'])->paginate(3);

        if ($request->ajax()) {
            return view('interfaces.trasladosPanel', compact('usuarios', 'animales', 'traslados'));
        } else {
            return view('interfaces.homePanel', [
                'modulo' => 'traslados',
                'usuarios' => $usuarios,
                'animales' => $animales,
                'traslados' => $traslados,
            ]);
        }
    }

    // Guardar un nuevo traslado
    /*public function store(Request $request)
    {
        $request->validate([
            'id_animal' => 'required|exists:animales,id',
            'origen' => 'required|string',
            'destino' => 'required|string',
            'fecha' => 'required|date',
            'responsable_id' => 'required|exists:users,id'
        ]);

        Traslado::create($request->all());

        return redirect()->route('traslados.index')->with('success', 'Registro de traslado agregado exitosamente.');
    }



    // Actualizar un traslado existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_animal' => 'required|exists:animales,id',
            'origen' => 'required|string',
            'destino' => 'required|string',
            'fecha' => 'required|date',
            'responsable_id' => 'required|exists:users,id'
        ]);

        $traslado = Traslado::findOrFail($id);
        $traslado->update($request->all());

        return redirect()->route('traslados.index')->with('success', 'Registro actualizado correctamente');
    }

    // Eliminar un traslado
    public function destroy($id)
    {
        try {
            $traslado = Traslado::findOrFail($id);
            $traslado->delete();

            return redirect()->route('traslados.index')->with('success', 'Registro de traslado eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('traslados.index')->with('error', 'Error al eliminar el registro de traslado.');
        }
    }*/

}

