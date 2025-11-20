<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Lista todos los usuarios
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filtro por rol
        if ($request->filled('rol')) {
            $query->where('rol', $request->rol);
        }

        // Búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('name', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%")
                  ->orWhere('telefono', 'like', "%{$buscar}%");
            });
        }

        $usuarios = $query->orderBy('created_at', 'desc')->paginate(20);

        // Estadísticas
        $stats = [
            'total' => User::count(),
            'admins' => User::where('rol', 'admin')->count(),
            'clientes' => User::where('rol', 'cliente')->count(),
        ];

        return view('administracion.usuarios.index', compact('usuarios', 'stats'));
    }

    /**
     * Mostrar detalle de un usuario
     */
    public function show(User $usuario)
    {
        $pedidos = $usuario->pedidos()->orderBy('created_at', 'desc')->get();
        return view('administracion.usuarios.show', [
            'user' => $usuario,
            'pedidos' => $pedidos
        ]);
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('administracion.usuarios.create');
    }

    /**
     * Crear nuevo usuario
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telefono' => 'required|string|max:15|unique:users,telefono',
            'password' => 'required|string|min:8|confirmed',
            'rol' => 'required|in:admin,cliente',
            'comuna' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:255',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'comuna' => $request->comuna,
            'ciudad' => $request->ciudad,
        ]);

        return redirect()->route('administracion.usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(User $usuario)
    {
        return view('administracion.usuarios.edit', compact('usuario'));
    }

    /**
     * Actualizar usuario
     */
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'telefono' => 'required|string|max:15|unique:users,telefono,' . $usuario->id,
            'password' => 'nullable|string|min:8|confirmed',
            'rol' => 'required|in:admin,cliente',
            'comuna' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:255',
        ]);

        $rolAnterior = $usuario->rol;

        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'rol' => $request->rol,
            'comuna' => $request->comuna,
            'ciudad' => $request->ciudad,
        ]);

        if ($request->filled('password')) {
            $usuario->update(['password' => Hash::make($request->password)]);
        }

        $mensaje = 'Usuario actualizado correctamente.';
        if ($rolAnterior !== $request->rol) {
            $mensaje .= " El rol cambió de '{$rolAnterior}' a '{$request->rol}'.";
        }

        return redirect()->route('administracion.usuarios.index')
            ->with('success', $mensaje);
    }

    /**
     * Eliminar usuario
     */
    public function destroy(User $usuario)
    {
        // No permitir eliminar al propio admin
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $usuario->delete();

        return redirect()->route('administracion.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
