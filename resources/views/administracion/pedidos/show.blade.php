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

                <!-- Galería de Archivos del Cliente -->
                @php
                    $itemsConArchivos = $pedido->items->filter(function($item) {
                        return !empty($item->ruta_archivo);
                    });
                @endphp

                @if($itemsConArchivos->count() > 0)
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl shadow-md p-6 border-2 border-purple-200">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">Archivos del Cliente</h2>
                                <p class="text-sm text-gray-600">{{ $itemsConArchivos->count() }} archivo(s) adjunto(s)</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($itemsConArchivos as $item)
                                @php
                                    $extension = pathinfo($item->ruta_archivo, PATHINFO_EXTENSION);
                                    $esImagen = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
                                @endphp
                                
                                <div class="group relative bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border-2 border-gray-200 hover:border-purple-400">
                                    @if($esImagen)
                                        <div class="aspect-square overflow-hidden cursor-pointer" 
                                             onclick="mostrarImagen('{{ asset('storage/' . $item->ruta_archivo) }}', '{{ basename($item->ruta_archivo) }}')">
                                            <img src="{{ asset('storage/' . $item->ruta_archivo) }}" 
                                                 alt="Vista previa"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 200 200\'%3E%3Crect fill=\'%23f3f4f6\' width=\'200\' height=\'200\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%239ca3af\' font-size=\'14\'%3ENo disponible%3C/text%3E%3C/svg%3E'">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    @else
                                        <div class="aspect-square bg-gray-100 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <div class="p-3 bg-white">
                                        <p class="text-xs font-semibold text-gray-700 truncate mb-1">
                                            {{ $item->producto->nombre ?? $item->cotizacion->nombre ?? 'Producto' }}
                                        </p>
                                        <p class="text-xs text-gray-500 truncate">{{ basename($item->ruta_archivo) }}</p>
                                        <div class="flex gap-1 mt-2">
                                            @if($esImagen)
                                                <button onclick="mostrarImagen('{{ asset('storage/' . $item->ruta_archivo) }}', '{{ basename($item->ruta_archivo) }}')" 
                                                        class="flex-1 px-2 py-1 bg-purple-100 hover:bg-purple-200 text-purple-700 text-xs font-semibold rounded transition-colors">
                                                    Ver
                                                </button>
                                            @endif
                                            <a href="{{ asset('storage/' . $item->ruta_archivo) }}" 
                                               download
                                               class="flex-1 px-2 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-xs font-semibold rounded transition-colors text-center">
                                                Descargar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

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
                                            <div class="mt-3 bg-gradient-to-r from-green-50 to-blue-50 rounded-lg p-3 border-2 border-green-200">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span class="text-sm text-green-700 font-bold">
                                                        Archivo del cliente adjunto
                                                    </span>
                                                </div>
                                                
                                                @php
                                                    $extension = pathinfo($item->ruta_archivo, PATHINFO_EXTENSION);
                                                    $esImagen = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
                                                @endphp

                                                @if($esImagen)
                                                    <!-- Vista previa de la imagen -->
                                                    <div class="mb-3">
                                                        <img src="{{ asset('storage/' . $item->ruta_archivo) }}" 
                                                             alt="Vista previa"
                                                             class="w-full max-w-xs h-48 object-cover rounded-lg border-2 border-gray-300 cursor-pointer hover:border-indigo-500 transition-all"
                                                             onclick="mostrarImagen('{{ asset('storage/' . $item->ruta_archivo) }}', '{{ basename($item->ruta_archivo) }}')"
                                                             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 200 200\'%3E%3Crect fill=\'%23f3f4f6\' width=\'200\' height=\'200\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%239ca3af\' font-size=\'14\'%3EImagen no disponible%3C/text%3E%3C/svg%3E'">
                                                    </div>
                                                @else
                                                    <!-- Icono para archivos no imagen -->
                                                    <div class="mb-3 flex items-center gap-3 bg-white p-3 rounded-lg border border-gray-200">
                                                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                            <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                            </svg>
                                                        </div>
                                                        <div class="flex-1">
                                                            <p class="font-semibold text-gray-800 text-sm">{{ basename($item->ruta_archivo) }}</p>
                                                            <p class="text-xs text-gray-500 uppercase">Archivo {{ strtoupper($extension) }}</p>
                                                        </div>
                                                    </div>
                                                @endif

                                                <!-- Botones de acción -->
                                                <div class="flex gap-2">
                                                    @if($esImagen)
                                                        <button onclick="mostrarImagen('{{ asset('storage/' . $item->ruta_archivo) }}', '{{ basename($item->ruta_archivo) }}')" 
                                                                class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 text-white text-sm font-bold rounded-lg transition-all shadow-md">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                            </svg>
                                                            Ver Imagen
                                                        </button>
                                                    @endif
                                                    <a href="{{ asset('storage/' . $item->ruta_archivo) }}" 
                                                       target="_blank"
                                                       download
                                                       class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white text-sm font-bold rounded-lg transition-all shadow-md">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                        </svg>
                                                        Descargar
                                                    </a>
                                                </div>
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
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 hidden items-center justify-center z-50 p-4" onclick="cerrarModal()">
    <div class="relative max-w-7xl w-full" onclick="event.stopPropagation()">
        <!-- Header del Modal -->
        <div class="bg-white rounded-t-xl p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900">Vista de Imagen</h3>
                    <p id="modalFileName" class="text-sm text-gray-600"></p>
                </div>
            </div>
            <button onclick="cerrarModal()" class="bg-red-100 hover:bg-red-200 text-red-600 rounded-lg w-10 h-10 flex items-center justify-center transition-colors shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <!-- Contenedor de la imagen -->
        <div class="bg-gray-900 rounded-b-xl p-6 flex items-center justify-center" style="max-height: calc(100vh - 150px);">
            <img id="modalImage" src="" alt="Archivo adjunto" class="max-w-full max-h-full rounded-lg shadow-2xl object-contain">
        </div>

        <!-- Botones de acción -->
        <div class="absolute bottom-4 right-4 flex gap-2">
            <a id="modalDownloadBtn" href="" download class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold flex items-center gap-2 shadow-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Descargar
            </a>
            <a id="modalOpenBtn" href="" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold flex items-center gap-2 shadow-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Abrir en nueva pestaña
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
function mostrarImagen(url, nombre = '') {
    const modal = document.getElementById('imageModal');
    const img = document.getElementById('modalImage');
    const fileName = document.getElementById('modalFileName');
    const downloadBtn = document.getElementById('modalDownloadBtn');
    const openBtn = document.getElementById('modalOpenBtn');
    
    img.src = url;
    fileName.textContent = nombre || 'Archivo adjunto';
    downloadBtn.href = url;
    openBtn.href = url;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden'; // Prevenir scroll
}

function cerrarModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = ''; // Restaurar scroll
}

// Cerrar con tecla ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        cerrarModal();
    }
});

// Mostrar indicador de carga mientras se carga la imagen
document.getElementById('modalImage').addEventListener('load', function() {
    this.style.opacity = '1';
});

document.getElementById('modalImage').addEventListener('loadstart', function() {
    this.style.opacity = '0.5';
});
</script>
@endpush

@endsection
