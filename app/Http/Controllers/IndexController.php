<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache; 
class IndexController extends Controller
{
    public function index()
    {
        // Verificamos si hay datos de caché para mostrar en la vista (por ejemplo, mensaje de bienvenida o preferencias de usuario)
        $welcomeMessage = Cache::get('welcome_message', '¡Bienvenido!'); // Si no existe, se utiliza el valor por defecto

        return view('index', compact('welcomeMessage'));
    }
    public function login(Request $request)
    {
        try {
            $request->validate([
                'identificacion' => 'required|string|max:255',
                'password' => 'required|string|min:8',
            ], [
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'password.required' => 'La contraseña es obligatoria.',
                'identificacion.required' => 'El usuario es obligatorio.',
            ]);

            // Intentar conexión con la base de datos
            $user = DB::table('usuarios')
                    ->where('identificacion', $request->identificacion)
                    ->first();

            if (!$user) {
                session()->flash('error', 'Error: No se pudo conectar con el servidor.');
                return back();
            }

            $passwordCheck = DB::selectOne("SELECT (password = crypt(?, password)) AS valid FROM usuarios WHERE identificacion = ?", 
                [$request->password, $request->identificacion]
            );

            if ($passwordCheck && $passwordCheck->valid) {

                // Aquí validamos si hay otra sesión activa distinta a esta
                $currentSessionId = session()->getId();

                $activeSessions = DB::table('sessions')
                ->where('user_id', $user->id)
                ->where('id', '!=', $currentSessionId)
                ->count();

                if ($activeSessions > 0) {
                    session()->flash('error', 'Este usuario ya tiene una sesión activa en otro dispositivo.');
                    return back()->onlyInput('identificacion');
                }
                // Si no hay otra sesión activa, procedemos con el inicio de sesión
                Auth::loginUsingId($user->id);

                // Actualizamos user_id en la sesión actual para poder trackearla
                DB::table('sessions')
                    ->where('id', $currentSessionId)
                    ->update(['user_id' => $user->id]);
                    
                $request->session()->regenerate();

                Cache::put('welcome_message', '¡Bienvenido, ' . $user->identificacion . '!', 60);

                session()->flash('success', 'Inicio de sesión exitoso.');
                return redirect()->route('homePanel');
            }

            session()->flash('error', 'Credenciales incorrectas. Verifique su usuario y contraseña.');
            return back()->onlyInput('identificacion');
            
        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash('error', 'No se pudo conectar con la base de datos. Intente más tarde.');
            return back();
            
        } catch (\Exception $e) {
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
        return redirect()->route('index');
    }
}
