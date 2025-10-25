<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; // Necesario para la validación

class RegisterController extends Controller
{
    /**
     * Muestra el formulario de registro para clientes.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Maneja la solicitud de registro de un nuevo cliente.
     */
    public function register(Request $request)
    {
        // 1. Validación de datos con reglas mejoradas
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            
            // 🚨 VALIDACIÓN DE CONTRASEÑA SEGURA: Min 8, Mayús, Minús, Número
            'password' => [
                'required', 
                'string', 
                'min:8', 
                'confirmed',
                'regex:/[a-z]/',    // Al menos una letra minúscula
                'regex:/[A-Z]/',    // Al menos una letra mayúscula
                'regex:/[0-9]/',    // Al menos un número
            ],
            
            // 🚨 NUEVOS CAMPOS LOGÍSTICOS
            'telefono' => ['required', 'string', 'max:15', 'unique:users'], // Único para evitar duplicados
            'comuna' => ['required', 'string', 'max:255'],
            'ciudad' => ['required', 'string', 'max:255'],
        ]);

        // 2. Creación del usuario (Asegúrate de que 'telefono', 'comuna', 'ciudad' estén en $fillable de User.php)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'cliente', 
            
            // 🚨 ASIGNACIÓN DE NUEVOS CAMPOS
            'telefono' => $request->telefono,
            'comuna' => $request->comuna,
            'ciudad' => $request->ciudad,
        ]);

        // 3. Inicio de sesión automático
        Auth::login($user);

        // 4. Redirección a la página principal
        return redirect()->route('home')
                         ->with('success', '¡Registro exitoso! Ya eres cliente de nuestra tienda.');
    }
}