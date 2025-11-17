@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50 py-8">
    <div class="max-w-2xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800">Editar Usuario</h1>
            <a href="{{ route('administracion.usuarios.index') }}" class="text-indigo-600 hover:underline">← Volver</a>
        </div>

        <div class="bg-white rounded-xl shadow-md p-8">
            <form action="{{ route('administracion.usuarios.update', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo *</label>
                        <input type="text" name="name" value="{{ old('name', $usuario->name) }}" required
                               class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $usuario->email) }}" required
                               class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono *</label>
                        <input type="text" name="telefono" value="{{ old('telefono', $usuario->telefono) }}" required
                               class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Comuna</label>
                            <input type="text" name="comuna" value="{{ old('comuna', $usuario->comuna) }}"
                                   class="w-full border rounded-lg px-4 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ciudad</label>
                            <input type="text" name="ciudad" value="{{ old('ciudad', $usuario->ciudad) }}"
                                   class="w-full border rounded-lg px-4 py-2">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rol *</label>
                        <select name="rol" required class="w-full border rounded-lg px-4 py-2">
                            <option value="cliente" {{ $usuario->rol == 'cliente' ? 'selected' : '' }}>Cliente</option>
                            <option value="admin" {{ $usuario->rol == 'admin' ? 'selected' : '' }}>Administrador</option>
                        </select>
                    </div>

                    <hr class="my-6">
                    <p class="text-sm text-gray-600 mb-4">Cambiar contraseña (dejar en blanco para mantener la actual)</p>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nueva Contraseña</label>
                        <input type="password" name="password" class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" class="w-full border rounded-lg px-4 py-2">
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700">
                        Guardar Cambios
                    </button>
                    <a href="{{ route('administracion.usuarios.index') }}" class="px-6 py-3 bg-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-400">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
