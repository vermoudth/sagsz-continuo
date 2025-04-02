<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache; // Asegúrate de incluir esta línea

class LogInController extends Controller
{
    public function show()
    {
        // Verificamos si hay datos de caché para mostrar en la vista (por ejemplo, mensaje de bienvenida o preferencias de usuario)
        $welcomeMessage = Cache::get('welcome_message', '¡Bienvenido!'); // Si no existe, se utiliza el valor por defecto

        return view('auth.login', compact('welcomeMessage'));
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'identificacion' => 'required|string|max:255',
                'password' => 'required|string|min:8',
            ]);

            // Intentar conexión con la base de datos
            $user = DB::table('usuarios')
                    ->where('identificacion', $request->identificacion)
                    ->first();

            // Verificar si la consulta falló (servidor caído)
            if (!$user) {
                session()->flash('error', 'Error: No se pudo conectar con el servidor.');
                return back();
            }

            // Verificar si la contraseña es correcta con PostgreSQL `crypt()`
            $passwordCheck = DB::selectOne("SELECT (password = crypt(?, password)) AS valid FROM usuarios WHERE identificacion = ?", 
                [$request->password, $request->identificacion]
            );

            // Si el usuario existe y la contraseña es correcta
            if ($passwordCheck && $passwordCheck->valid) {
                Auth::loginUsingId($user->id);
                $request->session()->regenerate();

                // Guardamos un valor en la caché para el mensaje de bienvenida
                Cache::put('welcome_message', '¡Bienvenido, ' . $user->identificacion . '!', 60); // 60 minutos

                session()->flash('success', 'Inicio de sesión exitoso.');
                return redirect()->route('homePanel');
            }

            // Si la contraseña es incorrecta
            session()->flash('error', 'Credenciales incorrectas. Verifique su usuario y contraseña.');
            return back()->onlyInput('identificacion');
            
        } catch (\Illuminate\Database\QueryException $e) {
            // Error de base de datos (posible falla de conexión)
            session()->flash('error', 'No se pudo conectar con la base de datos. Intente más tarde.');
            return back();
            
        } catch (\Exception $e) {
            // Cualquier otro error inesperado
            session()->flash('error', 'Error en el servidor: ' . $e->getMessage());
            return back();
        }
    }

    public function logout(Request $request)
    {
        // Limpiamos la caché de bienvenida al cerrar sesión
        Cache::forget('welcome_message'); // Elimina el mensaje de bienvenida

        Auth::logout(); // Cierra la sesión del usuario

        $request->session()->invalidate(); // Invalida la sesión actual
        $request->session()->regenerateToken(); // Regenera el token CSRF para seguridad

        session()->flash('success', 'Sesión cerrada exitosamente.');
        return redirect()->route('home');
    }
}
