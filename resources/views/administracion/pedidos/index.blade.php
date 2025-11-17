@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-extrabold text-gray-800 mb-2">📦 Gestión de Pedidos</h1>
            <p class="text-gray-600">Administra todos los pedidos del sistema</p>
        </div>

        <!-- Estadísticas Rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <p class="text-gray-600 text-sm">Total</p>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                <p class="text-gray-600 text-sm">Pendientes</p>
                <p class="text-3xl font-bold text-yellow-600">{{ $stats['pendientes'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                <p class="text-gray-600 text-sm">Pagados</p>
                <p class="text-3xl font-bold text-green-600">{{ $stats['pagados'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
                <p class="text-gray-600 text-sm">En Proceso</p>
                <p class="text-3xl font-bold text-purple-600">{{ $stats['en_proceso'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-indigo-500">
                <p class="text-gray-600 text-sm">Completados</p>
                <p class="text-3xl font-bold text-indigo-600">{{ $stats['completados'] }}</p>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <form method="GET" action="{{ route('administracion.pedidos.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                    <input type="text" name="buscar" value="{{ request('buscar') }}" 
                           placeholder="ID, nombre, email..." 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                    <select name="estado" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        <option value="">Todos</option>
                        <option value="pendiente_pago" {{ request('estado') == 'pendiente_pago' ? 'selected' : '' }}>Pendiente Pago</option>
                        <option value="pagado" {{ request('estado') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                        <option value="en_proceso" {{ request('estado') == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                        <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                        <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Desde</label>
                    <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hasta</label>
                    <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2">
                </div>
                <div class="md:col-span-4 flex gap-3">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">
                        Filtrar
                    </button>
                    <a href="{{ route('administracion.pedidos.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        <!-- Tabla de Pedidos -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pedidos as $pedido)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono font-bold text-indigo-600">#{{ $pedido->id }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-900">{{ $pedido->usuario->name }}</p>
                                <p class="text-sm text-gray-500">{{ $pedido->usuario->email }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $pedido->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-green-600">
                                ${{ number_format($pedido->total, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $estadoClasses = [
                                        'pendiente_pago' => 'bg-yellow-100 text-yellow-800',
                                        'pagado' => 'bg-green-100 text-green-800',
                                        'en_proceso' => 'bg-blue-100 text-blue-800',
                                        'completado' => 'bg-indigo-100 text-indigo-800',
                                        'cancelado' => 'bg-red-100 text-red-800',
                                        'pago_rechazado' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $estadoClasses[$pedido->estado] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst(str_replace('_', ' ', $pedido->estado)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $pedido->items->count() }} items
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('administracion.pedidos.show', $pedido->id) }}" 
                                   class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                    Ver Detalle →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                No se encontraron pedidos.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $pedidos->links() }}
        </div>
    </div>
</div>
@endsection
