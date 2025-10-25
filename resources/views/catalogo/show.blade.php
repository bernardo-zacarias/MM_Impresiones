<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $producto->nombre }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-8 bg-gray-50">

    <div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-2xl">
        <a href="{{ route('catalogo.index') }}" class="text-indigo-600 hover:underline mb-6 block">
            ← Volver al Catálogo
        </a>

        @if ($errors->any())
            <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg mt-6 mb-6 shadow-md">
                <p class="font-bold mb-2">⚠️ Por favor, corrige los siguientes errores:</p>
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            
            <div>
                <img 
                    src="{{ $producto->imagen ?? 'https://picsum.photos/600/400' }}" 
                    alt="{{ $producto->nombre }}" 
                    class="w-full rounded-lg shadow-xl mb-6"
                >
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Descripción</h2>
                <p class="text-gray-600">
                    {{ $producto->descripcion ?? 'Producto sin descripción detallada.' }}
                </p>
            </div>

            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 mb-2">
                    {{ $producto->nombre }}
                </h1>
                <p class="text-lg text-gray-500 mb-4">
                    Categoría: {{ $producto->categoria->nombre ?? 'N/A' }}
                </p>

                <div class="p-4 bg-green-50 rounded-lg mb-6 border border-green-200">
                    <p class="text-3xl font-extrabold text-green-700">
                        Precio: ${{ number_format($producto->precio, 0, ',', '.') }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">Stock disponible: {{ $producto->stock }} unidades</p>
                </div>

                @if (Auth::check())
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Añadir al Carrito</h3>
                    <form action="{{ route('carrito.store') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                        
                        <input type="hidden" name="cotizacion_id" value=""> 
                        
                        <input type="hidden" name="ancho" value="">
                        <input type="hidden" name="alto" value="">
                        <input type="hidden" name="costo_final" value="">
                        <input type="hidden" name="requiere_diseno" value=""> 
                        
                        <div>
                            <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad</label>
                            <input type="number" name="cantidad" id="cantidad" min="1" max="{{ $producto->stock }}" value="{{ old('cantidad', 1) }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-lg p-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('cantidad')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="p-4 bg-blue-50 rounded-lg border border-blue-200 space-y-3">
                            <label class="block text-sm font-medium text-gray-700">Opciones de Archivo (Selección obligatoria)</label>
                            
                            <div class="flex items-center">
                                <input type="radio" id="subir_archivo" name="opcion_archivo" value="subir" 
                                       class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500" required>
                                <label for="subir_archivo" class="ml-2 text-sm font-medium text-gray-700">
                                    Yo proporciono el archivo de impresión (Sin costo adicional)
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="radio" id="solicitar_diseno" name="opcion_archivo" value="diseno" 
                                       class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <label for="solicitar_diseno" class="ml-2 text-sm font-medium text-gray-700">
                                    Solicitar Diseño Gráfico (Costo adicional: $10.000)
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition duration-150 shadow-md">
                            Añadir al Carrito
                        </button>
                    </form>
                @else
                    <div class="p-6 bg-red-100 border border-red-400 text-red-700 rounded-lg mt-6 shadow-lg">
                        <p class="font-bold mb-2">¡Debes iniciar sesión para comprar!</p>
                        <p class="text-sm">Para añadir productos al carrito, por favor <a href="{{ route('login') }}" class="underline font-semibold">inicia sesión</a> o <a href="{{ route('register') }}" class="underline font-semibold">regístrate</a>.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>