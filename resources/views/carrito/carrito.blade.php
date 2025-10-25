<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - MM Impresiones</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f9; }
    </style>
</head>
<body class="p-8">

    <div class="max-w-6xl mx-auto">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-8 border-b pb-2">
            Tu Carrito de Compras 🛒
        </h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6 shadow-md" role="alert">
                <strong class="font-bold">¡Éxito!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6 shadow-md" role="alert">
                <strong class="font-bold">¡Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        
        @if ($items->isEmpty())
            <div class="p-10 bg-white rounded-xl shadow-lg text-center">
                <p class="text-xl text-gray-600">Tu carrito está vacío. ¡Añade productos de tu catálogo o cotiza un trabajo!</p>
                <a href="{{ route('catalogo.index') }}" class="mt-4 inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150">
                    Ir al Catálogo
                </a>
                <a href="{{ route('cotizador.index') }}" class="mt-4 ml-4 inline-block border border-indigo-600 text-indigo-600 font-bold py-2 px-4 rounded-lg transition duration-150">
                    Ir al Cotizador
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Columna Izquierda: Listado de Ítems --}}
                <div class="lg:col-span-2 space-y-4">
                    @php $granTotal = 0; @endphp

                    @foreach ($items as $item)
                        @php
                            $granTotal += $item->costo_final;
                            $esCotizado = $item->ancho > 0 || $item->alto > 0;
                            // Nombre del ítem
                            $nombreItem = $item->cotizacion->nombre ?? 'Ítem no identificado';
                            // Si tiene producto asociado, lo usamos
                            $nombreProducto = $item->cotizacion->producto->nombre ?? 'Servicio Genérico';
                            
                            // Determinar si es Catálogo (medidas 0) o Cotización (medidas > 0)
                            $tipoOrigen = $esCotizado ? 'Cotización Detallada' : 'Compra de Catálogo';
                        @endphp
                        
                        <div class="flex bg-white p-4 rounded-xl shadow-md items-center border border-gray-100">
                            
                            <div class="flex-shrink-0 mr-4">
                                <img src="{{ $item->cotizacion->producto->imagen ?? 'https://via.placeholder.com/60x60?text=MM' }}" alt="{{ $nombreProducto }}" class="w-16 h-16 object-cover rounded-lg">
                            </div>

                            <div class="flex-grow">
                                <h2 class="text-lg font-bold text-gray-800">{{ $nombreProducto }} - {{ $nombreItem }}</h2>
                                
                                <p class="text-sm text-gray-500">
                                    <span class="font-semibold">{{ $tipoOrigen }}:</span>
                                    @if ($esCotizado)
                                        {{ $item->ancho }}m x {{ $item->alto }}m | Cant: {{ $item->cantidad }}
                                    @else
                                            {{-- 🚨 CORRECCIÓN CLAVE: Usamos la relación 'producto' si existe, si no, usamos 'cotizacion' con precaución --}}
                                            Cant: {{ $item->cantidad }} (Precio Unitario: ${{ 
                                                number_format(
                                                    $item->producto->precio ?? $item->cotizacion->valor ?? 0, 
                                                    0, 
                                                    ',', 
                                                    '.'
                                                ) 
                                            }})
                                        @endif
                                    </p>
                                
                                <p class="text-sm {{ $item->requiere_diseno ? 'text-red-600' : 'text-gray-500' }} font-semibold mt-1">
                                    Diseño Gráfico: {{ $item->requiere_diseno ? 'Sí (+ $10.000 Incluido)' : 'No Requerido' }}
                                </p>
                            </div>

                            <div class="flex-shrink-0 text-right">
                                <p class="text-xl font-extrabold text-indigo-600">
                                    ${{ number_format($item->costo_final, 0, ',', '.') }}
                                </p>
                                
                                <form action="{{ route('carrito.destroy', ['item' => $item->id]) }}" method="POST" class="mt-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:text-red-700 underline" onclick="return confirm('¿Estás seguro de eliminar este ítem del carrito?');">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Columna Derecha: Resumen del Pedido --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-10 p-6 bg-white rounded-xl shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold border-b pb-3 mb-4 text-gray-800">Resumen de la Compra</h2>
                        
                        <div class="flex justify-between text-lg mb-4">
                            <span>Total de Productos (Sin Envío):</span>
                            <span class="font-semibold">${{ number_format($granTotal, 0, ',', '.') }}</span>
                        </div>
                        
                        {{-- Simulación de botón de pago --}}
                        <div class="flex justify-between text-lg font-bold border-t border-gray-300 pt-3">
                            <span>TOTAL FINAL:</span>
                            <span class="text-2xl text-green-600 font-extrabold">${{ number_format($granTotal, 0, ',', '.') }}</span>
                        </div>

                        <button 
                            onclick="alert('Redirigiendo a tu pasarela de pago (ej. Mercado Pago, Transbank) con un total de ${{ number_format($granTotal, 0, ',', '.') }}.')" 
                            class="w-full mt-6 bg-green-500 text-white font-bold py-3 rounded-lg hover:bg-green-600 transition duration-150 shadow-lg">
                            Pagar Ahora
                        </button>

                        <a href="{{ route('catalogo.index') }}" class="w-full block text-center mt-3 border border-indigo-500 text-indigo-500 font-bold py-2 rounded-lg hover:bg-indigo-50 transition duration-150">
                            Seguir Comprando
                        </a>
                        
                        <p class="text-xs text-gray-500 mt-3 text-center">
                            Al pagar, se generará el pedido formal para el administrador.
                        </p>
                    </div>
                </div>

            </div>
        @endif
    </div>
</body>
</html>