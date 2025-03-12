<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogInController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validación de los datos de entrada (se eliminó la regla 'unique:users,email')
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Intento de inicio de sesión
        if (Auth::attempt($request->only('email', 'password'))) {
            // Regenerar la sesión para evitar ataques de fijación de sesión
            $request->session()->regenerate();

            // Redireccionar al panel de inicio con éxito
            return redirect()->route('homePanel')->with('success', 'Inicio de sesión exitoso.');
        }

        // Si la autenticación falla, redireccionar de vuelta con un mensaje de error
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Cierra la sesión del usuario

        $request->session()->invalidate(); // Invalida la sesión actual
        $request->session()->regenerateToken(); // Regenera el token CSRF para seguridad

        return redirect()->route('home')->with('success', 'Sesión cerrada exitosamente.');
    }

}
