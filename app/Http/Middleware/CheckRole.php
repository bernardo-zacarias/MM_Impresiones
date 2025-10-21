<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string $rol El rol requerido para acceder a la ruta (ej: 'admin', 'cliente')
     */
    public function handle(Request $request, Closure $next, string $rol): Response
    {
        // 1. Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, lo enviamos al home con un error
            return redirect('/home')->with('error', 'Debes iniciar sesión para acceder.');
        }

        $user = Auth::user();

        // 2. Verificar el rol del usuario.
        // Si el rol del usuario NO es el rol requerido ($rol), lo bloquea.
        if ($user->rol !== $rol) {
            // Redirige a la home con un mensaje de error claro
            return redirect('/home')->with('error', 'Acceso no autorizado. Tu rol de ' . $user->rol . ' no tiene permisos para esta sección.');
        }

        // 3. Si todo es correcto (autenticado y con el rol correcto), permite la solicitud
        return $next($request);
    }
}
