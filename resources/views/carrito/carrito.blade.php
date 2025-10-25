<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - MM Impresiones</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
@extends('layouts.app')

<body class="bg-gradient-to-br from-gray-50 to-indigo-50 min-h-screen">

    <div class="max-w-7xl mx-auto p-8">
        <!-- Header -->
        <div class="mb-10">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-1 h-16 bg-gradient-to-b from-indigo-500 to-purple-500 rounded-full"></div>
                <div>
                    <h1 class="text-5xl font-extrabold text-gray-800 bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        Tu Carrito de Compras
                    </h1>
                    <p class="text-gray-600 text-lg mt-2">Revisa tus productos antes de continuar</p>
                </div>
            </div>
        </div>

        <!-- Mensajes de Éxito/Error -->
        @if (session('success'))
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 px-6 py-4 rounded-xl relative mb-8 shadow-lg" role="alert">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <strong class="font-bold text-green-800">¡Éxito!</strong>
                        <span class="block sm:inline text-green-700">{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 px-6 py-4 rounded-xl relative mb-8 shadow-lg" role="alert">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <strong class="font-bold text-red-800">¡Error!</strong>
                        <span class="block sm:inline text-red-700">{{ session('error') }}</span>
                    </div>
                </div>
            </div>
        @endif
        
        @if ($items->isEmpty())
            <!-- Carrito Vacío -->
            <div class="bg-white rounded-3xl shadow-2xl p-16 text-center border border-gray-100">
                <div class="max-w-md mx-auto">
                    <svg class="w-32 h-32 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Tu carrito está vacío</h2>
                    <p class="text-gray-600 mb-8 text-lg">¡Añade productos de nuestro catálogo o cotiza un trabajo personalizado!</p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('catalogo.index') }}" class="group relative block overflow-hidden rounded-xl bg-gradient-to-br from-indigo-600 via-indigo-500 to-purple-600 p-0.5 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                            <div class="relative bg-white rounded-xl overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="relative px-8 py-4 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-600 group-hover:text-purple-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    <span class="font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent group-hover:from-purple-600 group-hover:to-indigo-600 transition-all duration-300">
                                        Ir al Catálogo
                                    </span>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('cotizador.index') }}" class="px-8 py-4 border-2 border-indigo-600 text-indigo-600 font-bold rounded-xl hover:bg-indigo-50 transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            Ir al Cotizador
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Columna Izquierda: Listado de Ítems --}}
                <div class="lg:col-span-2 space-y-6">
                    @php $granTotal = 0; @endphp

                    @foreach ($items as $item)
                        @php
                            $granTotal += $item->costo_final;
                            $esCotizado = $item->ancho > 0 || $item->alto > 0;
                            $nombreItem = $item->cotizacion->nombre ?? 'Ítem no identificado';
                            $nombreProducto = $item->cotizacion->producto->nombre ?? 'Servicio Genérico';
                            $tipoOrigen = $esCotizado ? 'Cotización Detallada' : 'Compra de Catálogo';
                        @endphp
                        
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 hover:shadow-2xl transition-all duration-300">
                            <div class="flex p-6 gap-6">
                                
                                <!-- Imagen del Producto -->
                                <div class="flex-shrink-0">
                                    <div class="relative group">
                                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/20 to-purple-500/20 rounded-xl"></div>
                                        <img src="{{ $item->cotizacion->producto->imagen ?? 'https://via.placeholder.com/120x120?text=MM' }}" 
                                             alt="{{ $nombreProducto }}" 
                                             class="relative w-28 h-28 object-cover rounded-xl shadow-lg">
                                    </div>
                                </div>

                                <!-- Información del Producto -->
                                <div class="flex-grow">
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold mb-2">
                                                {{ $tipoOrigen }}
                                            </span>
                                            <h2 class="text-xl font-bold text-gray-800">{{ $nombreProducto }}</h2>
                                            <p class="text-sm text-gray-600 mt-1">{{ $nombreItem }}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Detalles -->
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-700 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                            </svg>
                                            @if ($esCotizado)
                                                <span class="font-semibold">Medidas:</span> {{ $item->ancho }}m x {{ $item->alto }}m | <span class="font-semibold">Cantidad:</span> {{ $item->cantidad }}
                                            @else
                                                <span class="font-semibold">Cantidad:</span> {{ $item->cantidad }} | 
                                                <span class="font-semibold">Precio Unitario:</span> ${{ 
                                                    number_format(
                                                        $item->producto->precio ?? $item->cotizacion->valor ?? 0, 
                                                        0, 
                                                        ',', 
                                                        '.'
                                                    ) 
                                                }}
                                            @endif
                                        </p>
                                        
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 {{ $item->requiere_diseno ? 'text-purple-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                            </svg>
                                            <p class="text-sm {{ $item->requiere_diseno ? 'text-purple-600 font-semibold' : 'text-gray-500' }}">
                                                Diseño Gráfico: {{ $item->requiere_diseno ? 'Sí (+$10.000 incluido)' : 'No requerido' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Precio y Acciones -->
                                <div class="flex-shrink-0 text-right flex flex-col justify-between">
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 mb-1">Total</p>
                                        <p class="text-3xl font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                            ${{ number_format($item->costo_final, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    
                                    <form action="{{ route('carrito.destroy', ['item' => $item->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-all font-semibold border border-red-200" 
                                                onclick="return confirm('¿Estás seguro de eliminar este ítem del carrito?');">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Columna Derecha: Resumen del Pedido --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-8 bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
                        <!-- Header del Resumen -->
                        <div class="bg-gradient-to-br from-indigo-600 to-purple-600 p-6 text-white">
                            <h2 class="text-2xl font-bold flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Resumen de Compra
                            </h2>
                        </div>

                        <div class="p-6 space-y-4">
                            <!-- Subtotal -->
                            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                <span class="text-gray-700 font-medium">Subtotal de Productos</span>
                                <span class="text-xl font-bold text-gray-800">${{ number_format($granTotal, 0, ',', '.') }}</span>
                            </div>

                            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                <span class="text-gray-700 font-medium flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                    </svg>
                                    Envío
                                </span>
                                <span class="text-sm text-gray-600">A calcular</span>
                            </div>
                            
                            <!-- Total Final -->
                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border-2 border-green-200">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-800">TOTAL FINAL</span>
                                    <span class="text-3xl font-extrabold text-green-700">${{ number_format($granTotal, 0, ',', '.') }}</span>
                                </div>
                                <p class="text-xs text-gray-600 mt-2">* Sin incluir costos de envío</p>
                            </div>

                            <!-- Botón de Pago -->
                            <button 
                                onclick="alert('Redirigiendo a tu pasarela de pago (ej. Mercado Pago, Transbank) con un total de ${{ number_format($granTotal, 0, ',', '.') }}.')" 
                                class="group relative block w-full overflow-hidden rounded-xl bg-gradient-to-br from-green-600 via-green-500 to-emerald-600 p-0.5 shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-[1.02]">
                                <div class="relative bg-gradient-to-br from-green-600 to-emerald-600 rounded-xl overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <div class="relative px-8 py-4 flex items-center justify-center gap-3">
                                        <svg class="w-6 h-6 text-white group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                        </svg>
                                        <span class="text-xl font-bold text-white">
                                            Proceder al Pago
                                        </span>
                                    </div>
                                </div>
                            </button>

                            <!-- Botón Seguir Comprando -->
                            <a href="{{ route('catalogo.index') }}" class="block w-full text-center px-6 py-3 border-2 border-indigo-600 text-indigo-600 font-bold rounded-xl hover:bg-indigo-50 transition-all duration-300 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Seguir Comprando
                            </a>
                            
                            <!-- Info adicional -->
                            <div class="mt-4 p-4 bg-blue-50 rounded-xl border border-blue-200">
                                <div class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-xs text-gray-700 leading-relaxed">
                                        Al finalizar el pago, se generará un pedido formal que será procesado por nuestro equipo.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endif
    </div>
</body>
</html>