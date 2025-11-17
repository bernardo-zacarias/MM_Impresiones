@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50 py-8">
    <div class="max-w-2xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800">Crear Nuevo Usuario</h1>
            <a href="{{ route('administracion.usuarios.index') }}" class="text-indigo-600 hover:underline">← Volver</a>
        </div>

        <div class="bg-white rounded-xl shadow-md p-8">
            <form action="{{ route('administracion.usuarios.store') }}" method="POST">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full border rounded-lg px-4 py-2 @error('name') border-red-500 @enderror">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full border rounded-lg px-4 py-2 @error('email') border-red-500 @enderror">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono *</label>
                        <input type="text" name="telefono" value="{{ old('telefono') }}" required
                               class="w-full border rounded-lg px-4 py-2 @error('telefono') border-red-500 @enderror">
                        @error('telefono')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Comuna</label>
                            <input type="text" name="comuna" value="{{ old('comuna') }}"
                                   class="w-full border rounded-lg px-4 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ciudad</label>
                            <input type="text" name="ciudad" value="{{ old('ciudad') }}"
                                   class="w-full border rounded-lg px-4 py-2">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rol *</label>
                        <select name="rol" required class="w-full border rounded-lg px-4 py-2">
                            <option value="cliente" {{ old('rol') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                            <option value="admin" {{ old('rol') == 'admin' ? 'selected' : '' }}>Administrador</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Contraseña *</label>
                        <input type="password" name="password" required
                               class="w-full border rounded-lg px-4 py-2 @error('password') border-red-500 @enderror">
                        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña *</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full border rounded-lg px-4 py-2">
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit" class="px-6 py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700">
                        Crear Usuario
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
