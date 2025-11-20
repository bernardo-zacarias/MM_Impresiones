@extends('layouts.app')

@section('title', 'Catálogo de Productos')

{{-- Usamos la sección 'content' para el diseño principal --}}
@section('content')

    <div class="max-w-4xl mx-auto bg-white p-10 rounded-2xl shadow-2xl border border-gray-100">
        
        <h1 class="text-3xl font-extrabold text-indigo-700 mb-2">
            ✅ Pedido Creado con Éxito (N° {{ $pedido->id }})
        </h1>
        <p class="text-gray-600 mb-6 border-b pb-4">
            Tu compra ha sido registrada. El estado actual es: 
            <span class="font-bold text-red-500 uppercase">{{ $pedido->estado }}</span>
        </p>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-8 space-y-4">
            <h2 class="text-xl font-bold text-gray-800">Resumen de la Orden</h2>
            <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Total:</strong> <span class="text-2xl font-extrabold text-green-600">${{ number_format($pedido->total, 0, ',', '.') }}</span></p>
            
            @if($pedido->estado === 'pendiente_pago')
                <!-- Botón para proceder al pago -->
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                    <div class="flex items-center gap-3 mb-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <p class="text-yellow-800 font-semibold">Pedido pendiente de pago</p>
                    </div>
                    <a href="{{ route('transbank.iniciar', $pedido->id) }}" 
                       class="inline-block w-full sm:w-auto px-6 py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition-all shadow-lg text-center">
                        💳 Pagar con Webpay
                    </a>
                </div>
            @elseif($pedido->estado === 'pagado')
                <!-- Información del pago exitoso -->
                <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-green-800 font-bold">✓ Pago Confirmado</p>
                            @if($pedido->transbank_authorization_code)
                                <p class="text-sm text-green-700">Código de autorización: <span class="font-mono">{{ $pedido->transbank_authorization_code }}</span></p>
                                <p class="text-sm text-green-700">Método: {{ $pedido->transbank_payment_type_code == 'VD' ? 'Débito' : ($pedido->transbank_payment_type_code == 'VN' ? 'Crédito' : 'Webpay') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @elseif($pedido->estado === 'pago_rechazado')
                <!-- Pago rechazado -->
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
                    <p class="text-red-800 font-semibold mb-3">⚠️ El pago fue rechazado</p>
                    <a href="{{ route('transbank.iniciar', $pedido->id) }}" 
                       class="inline-block px-6 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all shadow-lg">
                        Intentar nuevamente
                    </a>
                </div>
            @endif
        </div>

        <div class="border border-gray-200 rounded-lg overflow-hidden">
            <h2 class="bg-gray-100 p-4 font-bold text-gray-800">Productos Comprados</h2>
            
            <ul class="divide-y divide-gray-200">
                @foreach ($items as $item)
                    @php
                        $esCotizado = $item->ancho > 0 || $item->alto > 0;
                        $nombreProducto = $item->producto->nombre ?? ($item->cotizacion->nombre ?? 'Ítem desconocido');
                        $origen = $esCotizado ? 'Cotización' : 'Catálogo';
                    @endphp
                    
                    <li class="p-4 flex justify-between items-center hover:bg-gray-50">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">{{ $nombreProducto }}</p>
                            <p class="text-sm text-gray-600">
                                Cantidad: {{ $item->cantidad }} | Origen: {{ $origen }}
                                @if ($esCotizado)
                                    | Medidas: {{ $item->ancho }}m x {{ $item->alto }}m
                                @endif
                            </p>
                            <p class="text-xs {{ $item->requiere_diseno ? 'text-red-500' : 'text-green-500' }}">
                                Diseño: {{ $item->requiere_diseno ? 'SOLICITADO' : 'Proporcionado' }}
                            </p>
                            
                            @if($item->ruta_archivo)
                                @php
                                    $extension = pathinfo($item->ruta_archivo, PATHINFO_EXTENSION);
                                    $esImagen = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
                                @endphp
                                <div class="mt-2 inline-flex items-center gap-2">
                                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded">
                                        ✓ Archivo adjunto
                                    </span>
                                    @if($esImagen)
                                        <button onclick="verArchivo('{{ asset('storage/' . $item->ruta_archivo) }}', '{{ basename($item->ruta_archivo) }}')" 
                                                class="px-2 py-1 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 text-xs font-semibold rounded transition-colors">
                                            Ver imagen
                                        </button>
                                    @endif
                                    <a href="{{ asset('storage/' . $item->ruta_archivo) }}" 
                                       download
                                       class="px-2 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-xs font-semibold rounded transition-colors">
                                        Descargar
                                    </a>
                                </div>
                            @endif
                        </div>
                        <span class="font-bold text-lg text-indigo-600">
                            ${{ number_format($item->costo_final, 0, ',', '.') }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
        
        <div class="mt-8 text-center">
            <a href="{{ route('pedidos.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium underline">
                Ver mi Historial de Pedidos
            </a>
        </div>
    </div>

    <!-- Modal para ver archivos -->
    <div id="archivoModal" class="fixed inset-0 bg-black bg-opacity-90 hidden items-center justify-center z-50 p-4" onclick="cerrarArchivo()">
        <div class="relative max-w-5xl w-full" onclick="event.stopPropagation()">
            <div class="bg-white rounded-t-xl p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Mi Archivo</h3>
                        <p id="archivoNombre" class="text-sm text-gray-600"></p>
                    </div>
                </div>
                <button onclick="cerrarArchivo()" class="bg-red-100 hover:bg-red-200 text-red-600 rounded-lg w-10 h-10 flex items-center justify-center transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div class="bg-gray-900 rounded-b-xl p-6 flex items-center justify-center" style="max-height: calc(100vh - 150px);">
                <img id="archivoImagen" src="" alt="Tu archivo" class="max-w-full max-h-full rounded-lg shadow-2xl">
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    function verArchivo(url, nombre) {
        const modal = document.getElementById('archivoModal');
        const img = document.getElementById('archivoImagen');
        const nombreEl = document.getElementById('archivoNombre');
        
        img.src = url;
        nombreEl.textContent = nombre;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function cerrarArchivo() {
        const modal = document.getElementById('archivoModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            cerrarArchivo();
        }
    });
    </script>
    @endpush
@endsection