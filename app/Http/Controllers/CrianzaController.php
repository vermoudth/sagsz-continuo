<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crianza;
use App\Models\Animal;
use App\Models\User;


class CrianzaController extends Controller
{
     // Mostrar todas las crianzas
    public function index()
    {   $animales = Animal::all();
        $usuarios = User::all();
        $crianzas = Crianza::with(['animal', 'responsable'])->paginate(10);
        return view('interfaces.crianzaPanel', compact('usuarios','animales','crianzas'));
    }

    // Mostrar el formulario de creación
    public function create()
    {
        return view('interfaces.crianzaPanel');
    }

    // Guardar una nueva crianza
    public function store(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animales,id',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'responsable_id' => 'required|exists:usuarios,id'
        ]);

        Crianza::create($request->all());

        return redirect()->route('homePanel')->with('success', 'Registro de crianza agregado exitosamente.');
    }

    // Mostrar detalles de una crianza específica
    public function show($id)
    {
        $crianza = Crianza::with(['animal', 'responsable'])->findOrFail($id);
        return view('interfaces.crianzaPanel', compact('crianza'));
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $crianza = Crianza::findOrFail($id);
        return view('interfaces.crianzaPanel', compact('crianza'));
    }

    // Actualizar una crianza existente
    public function update(Request $request, $id)
    {
        $crianza = Crianza::findOrFail($id);
        $crianza->animal_id = $request->animal_id;
        $crianza->descripcion = $request->descripcion;
        $crianza->fecha = $request->fecha;
        $crianza->responsable_id = $request->responsable_id;
        $crianza->save();

        return redirect()->back()->with('success', 'Crianza actualizada correctamente.');
    }

    // Eliminar una crianza
    public function destroy($id)
    {
        $crianza = Crianza::findOrFail($id);
        $crianza->delete();

        return redirect()->route('homePanel')->with('success', 'Registro de crianza eliminado correctamente.');
    }
}
