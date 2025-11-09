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
            <p><strong>Total Pagado (Pendiente):</strong> <span class="text-2xl font-extrabold text-green-600">${{ number_format($pedido->total, 0, ',', '.') }}</span></p>
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
                                @if($item->ruta_archivo)
                                    (Archivo adjunto: Sí)
                                @endif
                            </p>
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
@endsection