<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
        // 1. Validación de datos
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // 2. Creación del usuario. IMPORTANTE: el campo 'rol' se establece en 'cliente' por defecto
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'cliente', 
        ]);

        // 3. Inicio de sesión automático
        Auth::login($user);

        // 4. Redirección a la página principal
        return redirect()->route('home')
                         ->with('success', '¡Registro exitoso! Ya eres cliente de nuestra tienda.');
    }
}
