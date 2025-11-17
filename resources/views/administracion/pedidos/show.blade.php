@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50 py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-800 mb-2">Pedido #{{ $pedido->id }}</h1>
                <p class="text-gray-600">Detalles completos del pedido</p>
            </div>
            <a href="{{ route('administracion.pedidos.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                ← Volver
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Columna Principal -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Info del Cliente -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Información del Cliente
                    </h2>
                    <div class="space-y-2">
                        <p><strong>Nombre:</strong> {{ $pedido->usuario->name }}</p>
                        <p><strong>Email:</strong> {{ $pedido->usuario->email }}</p>
                        <p><strong>Teléfono:</strong> {{ $pedido->usuario->telefono ?? 'No proporcionado' }}</p>
                        @if($pedido->usuario->comuna || $pedido->usuario->ciudad)
                            <p><strong>Ubicación:</strong> {{ $pedido->usuario->comuna }}, {{ $pedido->usuario->ciudad }}</p>
                        @endif
                    </div>
                </div>

                <!-- Items del Pedido -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Productos del Pedido</h2>
                    <div class="space-y-4">
                        @foreach($pedido->items as $item)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <p class="font-bold text-gray-900">
                                            {{ $item->producto->nombre ?? $item->cotizacion->nombre ?? 'Producto' }}
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Cantidad: {{ $item->cantidad }}
                                            @if($item->ancho > 0 || $item->alto > 0)
                                                | Medidas: {{ $item->ancho }}m x {{ $item->alto }}m
                                            @endif
                                        </p>
                                        @if($item->requiere_diseno)
                                            <span class="inline-block mt-2 px-3 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full">
                                                🎨 Requiere Diseño
                                            </span>
                                        @endif
                                        @if($item->ruta_archivo)
                                            <div class="mt-3 flex items-center gap-2">
                                                <span class="text-sm text-green-600 font-semibold">
                                                    ✓ Archivo adjunto:
                                                </span>
                                                <a href="{{ asset('storage/' . $item->ruta_archivo) }}" 
                                                   target="_blank"
                                                   download
                                                   class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-lg hover:bg-blue-200 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                    Descargar
                                                </a>
                                                <button onclick="mostrarImagen('{{ asset('storage/' . $item->ruta_archivo) }}')" 
                                                        class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-lg hover:bg-green-200 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    Ver
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xl font-bold text-indigo-600">
                                            ${{ number_format($item->costo_final, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Notas -->
                @if($pedido->notas_cliente)
                    <div class="bg-blue-50 border-l-4 border-blue-400 rounded-lg p-6">
                        <h3 class="font-bold text-blue-900 mb-2">Notas del Cliente</h3>
                        <p class="text-blue-800">{{ $pedido->notas_cliente }}</p>
                    </div>
                @endif

                <!-- Formulario de Notas del Admin -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Notas del Administrador</h2>
                    <form action="{{ route('administracion.pedidos.notas', $pedido->id) }}" method="POST">
                        @csrf
                        <textarea name="notas_admin" rows="4" 
                                  class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-500"
                                  placeholder="Agregar notas internas...">{{ $pedido->notas_admin }}</textarea>
                        <button type="submit" class="mt-3 px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">
                            Guardar Notas
                        </button>
                    </form>
                </div>
            </div>

            <!-- Columna Lateral -->
            <div class="space-y-6">
                <!-- Resumen -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Resumen</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Fecha</p>
                            <p class="font-semibold">{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Estado Actual</p>
                            <p class="font-semibold text-lg">{{ ucfirst(str_replace('_', ' ', $pedido->estado)) }}</p>
                        </div>
                        <div class="border-t pt-3">
                            <p class="text-sm text-gray-600">Total</p>
                            <p class="text-3xl font-extrabold text-green-600">
                                ${{ number_format($pedido->total, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Cambiar Estado -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Cambiar Estado</h2>
                    <form action="{{ route('administracion.pedidos.estado', $pedido->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="estado" class="w-full border border-gray-300 rounded-lg px-4 py-3 mb-3">
                            <option value="pendiente_pago" {{ $pedido->estado == 'pendiente_pago' ? 'selected' : '' }}>Pendiente Pago</option>
                            <option value="pagado" {{ $pedido->estado == 'pagado' ? 'selected' : '' }}>Pagado</option>
                            <option value="en_proceso" {{ $pedido->estado == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                            <option value="completado" {{ $pedido->estado == 'completado' ? 'selected' : '' }}>Completado</option>
                            <option value="cancelado" {{ $pedido->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                        <button type="submit" class="w-full px-6 py-3 bg-purple-600 text-white font-bold rounded-lg hover:bg-purple-700">
                            Actualizar Estado
                        </button>
                    </form>
                </div>

                <!-- Info de Pago -->
                @if($pedido->transbank_authorization_code)
                    <div class="bg-green-50 border-2 border-green-400 rounded-xl p-6">
                        <h2 class="text-lg font-bold text-green-900 mb-3">✓ Información de Pago</h2>
                        <div class="space-y-2 text-sm">
                            <p><strong>Código:</strong> {{ $pedido->transbank_authorization_code }}</p>
                            <p><strong>Orden:</strong> {{ $pedido->transbank_buy_order }}</p>
                            <p><strong>Tipo:</strong> {{ $pedido->transbank_payment_type_code == 'VD' ? 'Débito' : 'Crédito' }}</p>
                            <p><strong>Monto:</strong> ${{ number_format($pedido->transbank_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Acciones -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Acciones</h2>
                    <div class="space-y-3">
                        @if($pedido->items()->whereNotNull('ruta_archivo')->count() > 0)
                            <a href="{{ route('administracion.pedidos.archivos', $pedido->id) }}" 
                               class="block w-full px-4 py-3 bg-blue-600 text-white text-center font-semibold rounded-lg hover:bg-blue-700">
                                📥 Descargar Archivos
                            </a>
                        @endif
                        <button onclick="window.print()" 
                                class="w-full px-4 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700">
                            🖨️ Imprimir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para visualizar imágenes -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50" onclick="cerrarModal()">
    <div class="relative max-w-5xl max-h-screen p-4" onclick="event.stopPropagation()">
        <button onclick="cerrarModal()" class="absolute top-2 right-2 bg-white text-gray-800 rounded-full w-10 h-10 flex items-center justify-center hover:bg-gray-200 shadow-lg z-10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <img id="modalImage" src="" alt="Archivo adjunto" class="max-w-full max-h-screen rounded-lg shadow-2xl">
    </div>
</div>

<script>
function mostrarImagen(url) {
    const modal = document.getElementById('imageModal');
    const img = document.getElementById('modalImage');
    img.src = url;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function cerrarModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Cerrar con tecla ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        cerrarModal();
    }
});
</script>

@endsection
