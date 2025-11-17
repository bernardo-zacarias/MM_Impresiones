@extends('administracion.dashboard')

@section('title', 'Ver Usuario')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Encabezado -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detalles del Usuario</h1>
            <p class="text-gray-600 mt-2">Información completa del usuario</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('administracion.usuarios.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                ← Volver
            </a>
            <a href="{{ route('administracion.usuarios.edit', $user->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                ✏️ Editar Usuario
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información Principal -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Información Personal
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre Completo</label>
                        <p class="text-gray-900 text-lg">{{ $user->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Correo Electrónico</label>
                        <p class="text-gray-900 text-lg">{{ $user->email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Teléfono</label>
                        <p class="text-gray-900 text-lg">{{ $user->telefono ?? 'No especificado' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Rol</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                            {{ $user->rol === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                            @if($user->rol === 'admin')
                                👑 Administrador
                            @else
                                👤 Cliente
                            @endif
                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Comuna</label>
                        <p class="text-gray-900">{{ $user->comuna ?? 'No especificado' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Ciudad</label>
                        <p class="text-gray-900">{{ $user->ciudad ?? 'No especificado' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Registro</label>
                        <p class="text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Última Actualización</label>
                        <p class="text-gray-900">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Pedidos del Usuario -->
            @if($pedidos->count() > 0)
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Historial de Pedidos ({{ $pedidos->count() }})
                </h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Fecha</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Total</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Estado</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pedidos as $pedido)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">#{{ $pedido->id }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $pedido->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">${{ number_format($pedido->total, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $estados = [
                                            'pendiente' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Pendiente'],
                                            'pagado' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Pagado'],
                                            'en_produccion' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'label' => 'En Producción'],
                                            'enviado' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-800', 'label' => 'Enviado'],
                                            'entregado' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Entregado'],
                                            'cancelado' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Cancelado'],
                                        ];
                                        $estado = $estados[$pedido->estado] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => $pedido->estado];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $estado['bg'] }} {{ $estado['text'] }}">
                                        {{ $estado['label'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <a href="{{ route('administracion.pedidos.show', $pedido->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                        Ver detalles →
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        <!-- Panel Lateral - Estadísticas -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Estadísticas</h2>

                <div class="space-y-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-blue-600 font-semibold">Total Pedidos</p>
                                <p class="text-2xl font-bold text-blue-900">{{ $pedidos->count() }}</p>
                            </div>
                            <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-green-600 font-semibold">Total Gastado</p>
                                <p class="text-2xl font-bold text-green-900">${{ number_format($pedidos->sum('total'), 0, ',', '.') }}</p>
                            </div>
                            <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="bg-yellow-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-yellow-600 font-semibold">Pedidos Pendientes</p>
                                <p class="text-2xl font-bold text-yellow-900">{{ $pedidos->where('estado', 'pendiente')->count() }}</p>
                            </div>
                            <svg class="w-10 h-10 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="bg-purple-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-purple-600 font-semibold">Cliente desde</p>
                                <p class="text-lg font-bold text-purple-900">{{ $user->created_at->diffForHumans() }}</p>
                            </div>
                            <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Acciones</h2>

                <div class="space-y-3">
                    <a href="{{ route('administracion.usuarios.edit', $user->id) }}" class="flex items-center gap-3 px-4 py-3 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span class="font-medium">Editar Usuario</span>
                    </a>

                    <form action="{{ route('administracion.usuarios.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <span class="font-medium">Eliminar Usuario</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
