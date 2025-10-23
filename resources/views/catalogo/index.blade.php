<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos - MM Impresiones</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-8 bg-gray-50">

    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-10 border-b pb-2">
            Catálogo de Productos Listos para Comprar
        </h1>

        @foreach ($categorias as $categoria)
            @if ($categoria->productos->count() > 0)
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-indigo-600 mb-6 border-l-4 border-indigo-400 pl-3">
                        {{ $categoria->nombre }}
                    </h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                        @foreach ($categoria->productos as $producto)
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-[1.03] transition duration-300">
                                
                                <a href="{{ route('catalogo.show', $producto->id) }}">
                                    <img 
                                        src="{{ $producto->imagen ?? 'https://via.placeholder.com/400x300?text=Sin+Imagen' }}" 
                                        alt="{{ $producto->nombre }}" 
                                        class="w-full h-48 object-cover"
                                    >
                                </a>

                                <div class="p-4">
                                    <h3 class="text-xl font-semibold text-gray-800 truncate mb-1">
                                        {{ $producto->nombre }}
                                    </h3>
                                    <p class="text-2xl font-extrabold text-green-600 mb-3">
                                        ${{ number_format($producto->precio, 0, ',', '.') }}
                                    </p>
                                    
                                    <a href="{{ route('catalogo.show', $producto->id) }}" class="block w-full text-center bg-indigo-500 text-white py-2 rounded-lg font-bold hover:bg-indigo-600 transition duration-150">
                                        Ver Detalles y Comprar
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</body>
</html>