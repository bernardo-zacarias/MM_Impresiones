<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $producto->nombre }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f9; }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-indigo-50 min-h-screen">

    <div class="max-w-7xl mx-auto p-8">
        <a href="{{ route('catalogo.index') }}" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-semibold mb-8 group transition-all">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver al Catálogo
        </a>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-xl mb-8 shadow-lg">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="font-bold text-red-800 mb-2">⚠️ Por favor, corrige los siguientes errores:</p>
                        <ul class="list-disc ml-5 text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                
                <div class="p-8 lg:p-12 bg-gradient-to-br from-gray-50 to-white">
                    <div class="relative group mb-8">
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/20 to-purple-500/20 rounded-2xl transform group-hover:scale-105 transition-transform duration-300"></div>
                        <img 
                            src="{{ $producto->imagen ?? 'https://picsum.photos/600/400' }}" 
                            alt="{{ $producto->nombre }}" 
                            class="relative w-full rounded-2xl shadow-xl object-cover aspect-square"
                        >
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-1 h-8 bg-gradient-to-b from-indigo-500 to-purple-500 rounded-full"></div>
                            <h2 class="text-3xl font-bold text-gray-800">Descripción del Producto</h2>
                        </div>
                        <p class="text-gray-600 text-lg leading-relaxed pl-6">
                            {{ $producto->descripcion ?? 'Este es un producto de alta calidad diseñado para satisfacer tus necesidades. Contáctanos para más información sobre características específicas.' }}
                        </p>
                    </div>

                    <div class="mt-8 p-6 bg-indigo-50 rounded-xl border border-indigo-200">
                        <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Beneficios
                        </h3>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                                Alta calidad de impresión
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                                Entrega rápida y segura
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                                Soporte personalizado
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="p-8 lg:p-12 space-y-8">
                    <div>
                        <div class="inline-block px-4 py-2 bg-indigo-100 text-indigo-700 rounded-full text-sm font-semibold mb-4">
                            {{ $producto->categoria->nombre ?? 'Producto' }}
                        </div>
                        <h1 class="text-5xl font-extrabold text-gray-900 mb-4 leading-tight">
                            {{ $producto->nombre }}
                        </h1>
                    </div>

                    <div class="p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl border-2 border-green-200 shadow-lg">
                        <div class="flex items-baseline gap-3 mb-3">
                            <p class="text-5xl font-extrabold text-green-700">
                                ${{ number_format($producto->precio, 0, ',', '.') }}
                            </p>
                            <span class="text-gray-600 text-lg">CLP</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-700">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <p class="font-semibold">Stock disponible: <span class="text-green-700">{{ $producto->stock }} unidades</span></p>
                        </div>
                    </div>

                    @if (Auth::check())
                        <div class="space-y-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-1 h-8 bg-gradient-to-b from-indigo-500 to-purple-500 rounded-full"></div>
                                <h3 class="text-2xl font-bold text-gray-800">Añadir al Carrito</h3>
                            </div>
                            
                            <form action="{{ route('carrito.store') }}" method="POST" id="form-catalogo" class="space-y-6" enctype="multipart/form-data">
                                @csrf
                                
                                <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                                <input type="hidden" name="cotizacion_id" value=""> 
                                <input type="hidden" name="ancho" value="">
                                <input type="hidden" name="alto" value="">
                                <input type="hidden" name="costo_final" value="">
                                <input type="hidden" name="requiere_diseno" value=""> 

                                <div class="space-y-2">
                                    <label for="cantidad" class="block text-sm font-bold text-gray-700 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                        </svg>
                                        Cantidad
                                    </label>
                                    <input type="number" name="cantidad" id="cantidad" min="1" max="{{ $producto->stock }}" value="{{ old('cantidad', 1) }}" 
                                           class="w-full border-2 border-gray-300 rounded-xl p-4 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-200 transition-all text-lg font-semibold" required>
                                    @error('cantidad')<p class="text-red-500 text-sm mt-1 flex items-center gap-1"><span>⚠️</span>{{ $message }}</p>@enderror
                                </div>

                                <div class="p-6 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl border-2 border-blue-200 space-y-4 shadow-lg">
                                    <label class="block text-base font-bold text-gray-800 flex items-center gap-2">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        Opciones de Archivo
                                        <span class="ml-auto text-xs bg-red-500 text-white px-2 py-1 rounded-full">Obligatorio</span>
                                    </label>
                                    
                                    <label class="flex items-start gap-3 p-4 bg-white rounded-xl border-2 border-gray-200 cursor-pointer hover:border-indigo-400 hover:shadow-md transition-all group">
                                        <input type="radio" id="subir_archivo" name="opcion_archivo" value="subir" 
                                               class="mt-1 h-5 w-5 text-indigo-600 border-gray-300 focus:ring-indigo-500" required>
                                        <div class="flex-1">
                                            <span class="font-semibold text-gray-800 group-hover:text-indigo-600 transition-colors">
                                                Yo proporciono el archivo de impresión
                                            </span>
                                            <p class="text-sm text-green-600 font-medium mt-1">✓ Sin costo adicional</p>
                                        </div>
                                    </label>

                                    <label class="flex items-start gap-3 p-4 bg-white rounded-xl border-2 border-gray-200 cursor-pointer hover:border-purple-400 hover:shadow-md transition-all group">
                                        <input type="radio" id="solicitar_diseno" name="opcion_archivo" value="diseno" 
                                               class="mt-1 h-5 w-5 text-purple-600 border-gray-300 focus:ring-purple-500">
                                        <div class="flex-1">
                                            <span class="font-semibold text-gray-800 group-hover:text-purple-600 transition-colors">
                                                Solicitar Diseño Gráfico Profesional
                                            </span>
                                            <p class="text-sm text-purple-600 font-medium mt-1">+ $10.000 CLP</p>
                                        </div>
                                    </label>

                                    <div class="pt-4 border-t-2 border-blue-200">
                                        <label for="archivo_diseno" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                            </svg>
                                            Subir tu Archivo de Impresión
                                            <span class="text-xs text-gray-500" id="file-upload-status"> (Máx. 10MB)</span>
                                        </label>
                                        <input type="file" name="archivo_diseno" id="archivo_diseno" 
                                               class="w-full p-3 border-2 border-dashed border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all hover:border-blue-400 cursor-pointer bg-white"/>
                                        <p class="text-xs text-gray-500 mt-2">Formatos aceptados: PDF, PNG, JPG, AI.</p>
                                    </div>
                                </div>

                                <button type="submit" id="btn-add-to-cart" class="group relative block w-full overflow-hidden rounded-xl bg-gradient-to-br from-indigo-600 via-indigo-500 to-purple-600 p-0.5 shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-[1.02]">
                                    <div class="relative bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <div class="relative px-8 py-4 flex items-center justify-center gap-3">
                                            <svg class="w-6 h-6 text-white group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            <span class="text-xl font-bold text-white">
                                                Añadir al Carrito
                                            </span>
                                            <svg class="w-6 h-6 text-white group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                            </svg>
                                        </div>
                                    </div>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="p-8 bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl border-2 border-yellow-300 text-center shadow-lg">
                            <svg class="w-16 h-16 mx-auto text-yellow-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Inicia Sesión para Comprar</h3>
                            <p class="text-gray-600 mb-6">Necesitas tener una cuenta para añadir productos al carrito</p>
                            <a href="{{ route('login') }}" class="inline-block px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg">
                                Iniciar Sesión
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const radioSubir = document.getElementById('subir_archivo');
            const radioDiseno = document.getElementById('solicitar_diseno');
            const inputFile = document.getElementById('archivo_diseno');
            const btnAddToCart = document.getElementById('btn-add-to-cart');
            const form = document.getElementById('form-catalogo');
            
            // Función para verificar si el botón debe estar habilitado
            function updateButtonState() {
                const isOptionSelected = radioSubir.checked || radioDiseno.checked;
                const isQuantityValid = parseInt(document.getElementById('cantidad').value) >= 1;
                
                let isArtRequirementMet = false;

                if (!isOptionSelected || !isQuantityValid) {
                    isArtRequirementMet = false;
                } else if (radioDiseno.checked) {
                    // Opción 2: Solicitar diseño - siempre es válida si está checked
                    isArtRequirementMet = true;
                } else if (radioSubir.checked) {
                    // Opción 1: Subir archivo - es válida si está checked Y hay un archivo
                    isArtRequirementMet = inputFile.files.length > 0;
                }
                
                btnAddToCart.disabled = !isArtRequirementMet;
            }

            // Event Listeners
            radioSubir.addEventListener('change', updateButtonState);
            radioDiseno.addEventListener('change', updateButtonState);
            inputFile.addEventListener('change', updateButtonState);
            document.getElementById('cantidad').addEventListener('input', updateButtonState);

            // Inicializar el estado del botón al cargar
            updateButtonState();
        });
    </script>

</body>
</html>