<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\User;

class FormAnimalController extends Controller
{
    public function create()
    {
        return view('interfaces.animal');
    }

    public function store(Request $request)
    {
        // Verificar si los datos llegan correctamente
        //dd($request->all());

        // Validar los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'especie' => 'required|string|max:255',
            'raza' => 'nullable|string|max:255',
            'edad' => 'nullable|integer|min:0',
            'peso' => 'nullable|numeric|min:0',
            'ubicacion' => 'nullable|string|max:255',
            'cuidador_id' => 'nullable|integer',
            'fecha_registro' => 'nullable|date',
        ]);

        // Guardar en la base de datos
        //Animal::create($request->all());
        $data = $request->all();
        if (!User::where('id', $request->cuidador_id)->exists()) {
            $data['cuidador_id'] = null;
        }
        Animal::create($data);

        return redirect()->route('homePanel')->with('success', 'Animal registrado con éxito.');
    }
}
