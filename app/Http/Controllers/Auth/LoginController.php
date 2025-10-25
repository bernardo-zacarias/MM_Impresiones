<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     */
    public function showLoginForm()
    {
        // Asegúrate de que esta vista exista: resources/views/auth/login.blade.php
        return view('auth.login');
    }

    /**
     * Maneja la solicitud de inicio de sesión.
     */
    public function login(Request $request)
    {
        // Validación básica
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirige según el rol del usuario
            if (Auth::user()->rol === 'admin') {
                return redirect()->route('administracion.dashboard');
            }
            
            // Si es 'cliente' o cualquier otro rol
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    
    
    // El Logout ya fue definido en web.php
}
