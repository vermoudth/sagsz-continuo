<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crianza;
use App\Models\Animal;
use App\Models\User;
use App\Models\CategoriaAnimal;


class CrianzaController extends Controller
{
    // Mostrar todas las crianzas
    public function index( Request $request)
    {   
        $animales = Animal::all();
        $usuarios = User::all();
        $categorias = CategoriaAnimal::all();

        // Filtro de categoría (opcional)
        $categoriaId = $request->input('categoria_id');

        $crianzas = Crianza::with(['animal.categoria', 'responsable'])
            ->when($categoriaId, function ($query, $categoriaId) {
                $query->whereHas('animal', function ($q) use ($categoriaId) {
                    $q->where('categoria_id', $categoriaId);
                });
            })
            ->paginate(3);

        if ($request->ajax()) {
            // Petición AJAX: devolver solo la vista parcial (sin layout)
            return view('interfaces.crianzaPanel', compact('usuarios','animales','crianzas', 'categorias'));
        } else {
            // Petición normal (recarga o acceso directo)
            // Layout completo con el módulo cargado dinámicamente
                return view('interfaces.homePanel', [
                    'modulo' => 'crianza',
                    'usuarios' => $usuarios,
                    'animales' => $animales,
                    'crianzas' => $crianzas,
                    'categorias' => $categorias,
                ]);
        }
    
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

        return redirect()->route('crianza.index')->with('success', 'Registro de crianza agregado exitosamente.');
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

        return redirect()->route('crianza.index')->with('success', 'Registro actualizado correctamente');

    }

    // Eliminar una crianza
    public function destroy($id)
    {
        try {
            $crianza = Crianza::findOrFail($id);
            $crianza->delete();

            return redirect()->route('crianza.index')->with('success', 'Registro de crianza eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('crianza.index')->with('error', 'Error al eliminar el registro de crianza.');
        }
    }

    public function filtrar(Request $request)
    {
        $categoria = $request->categoria;
        $crianzas = Crianza::whereHas('animal', function ($query) use ($categoria) {
            $query->where('categoria', $categoria);
        })->with(['animal', 'responsable'])->get();

        return view('partials.crianzaCards', compact('crianzas'));
    }

}
