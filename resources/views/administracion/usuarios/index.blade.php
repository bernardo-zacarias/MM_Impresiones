@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-800">👥 Gestión de Usuarios</h1>
                <p class="text-gray-600">Administra los usuarios del sistema</p>
            </div>
            <a href="{{ route('administracion.usuarios.create') }}" class="px-6 py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700">
                + Nuevo Usuario
            </a>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <p class="text-gray-600 text-sm">Total Usuarios</p>
                <p class="text-3xl font-bold">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
                <p class="text-gray-600 text-sm">Administradores</p>
                <p class="text-3xl font-bold text-purple-600">{{ $stats['admins'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                <p class="text-gray-600 text-sm">Clientes</p>
                <p class="text-3xl font-bold text-green-600">{{ $stats['clientes'] }}</p>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <input type="text" name="buscar" value="{{ request('buscar') }}" 
                           placeholder="Buscar por nombre, email, teléfono..." 
                           class="w-full border rounded-lg px-4 py-2">
                </div>
                <div>
                    <select name="rol" class="w-full border rounded-lg px-4 py-2">
                        <option value="">Todos los roles</option>
                        <option value="admin" {{ request('rol') == 'admin' ? 'selected' : '' }}>Administradores</option>
                        <option value="cliente" {{ request('rol') == 'cliente' ? 'selected' : '' }}>Clientes</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Filtrar</button>
                    <a href="{{ route('administracion.usuarios.index') }}" class="px-6 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Limpiar</a>
                </div>
            </form>
        </div>

        <!-- Tabla -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teléfono</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rol</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registro</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($usuarios as $usuario)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-900">{{ $usuario->name }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $usuario->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $usuario->telefono ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $usuario->rol == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($usuario->rol) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $usuario->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('administracion.usuarios.edit', $usuario->id) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                @if($usuario->id !== auth()->id())
                                    <form action="{{ route('administracion.usuarios.destroy', $usuario->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar usuario?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">No se encontraron usuarios.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $usuarios->links() }}</div>
    </div>
</div>
@endsection
