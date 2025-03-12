<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Exception;

class RegistrationController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            // Iniciar transacción en caso de que ocurra un error en la creación del usuario
            DB::beginTransaction();

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            DB::commit(); // Confirmar la transacción

            return redirect()->route('homePanel')->with('success', 'Registro completado con éxito.');
        } catch (Exception $e) {
            DB::rollBack(); // Revertir cambios en caso de error

            return back()->withErrors([
                'error' => 'Hubo un problema con el registro. Inténtalo de nuevo.',
            ])->withInput();
        }
    }
}
