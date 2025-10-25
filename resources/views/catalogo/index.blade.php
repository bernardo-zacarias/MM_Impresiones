<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos - MM Impresiones</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
@extends('layouts.app')

<body class="bg-gradient-to-br from-gray-50 to-indigo-50 min-h-screen">

    <div class="flex min-h-screen">
        <!-- Sidebar Izquierdo -->
        <aside class="w-80 bg-white shadow-2xl sticky top-0 h-screen overflow-y-auto border-r-4 border-indigo-200">
            <div class="p-6 bg-gradient-to-br from-indigo-600 to-purple-600">
                <h2 class="text-2xl font-bold text-white mb-2 flex items-center gap-2">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                    Categorías
                </h2>
                <p class="text-indigo-100 text-sm">Explora nuestros productos</p>
            </div>

            <!-- Barra de búsqueda -->
            <div class="p-4 border-b">
                <div class="relative">
                    <input 
                        type="text" 
                        placeholder="Buscar productos..." 
                        class="w-full pl-10 pr-4 py-3 border-2 border-indigo-200 rounded-xl focus:outline-none focus:border-indigo-500 transition-all"
                        id="searchInput"
                        onkeyup="filterProducts()"
                    >
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Botón Ver Todos -->
            <div class="p-4 border-b">
                <button 
                    onclick="showAllCategories()" 
                    class="w-full flex items-center justify-center gap-2 p-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl transform hover:scale-105"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    <span class="font-bold">Ver Todos los Productos</span>
                </button>
            </div>

            <!-- Lista de Categorías -->
            <nav class="p-4">
                <div class="space-y-2">
                    @foreach ($categorias as $index => $categoria)
                        @if ($categoria->productos->count() > 0)
                            <div class="border-b border-gray-200 pb-3">
                                <button 
                                    onclick="toggleCategory('cat-{{ $categoria->id }}')" 
                                    class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-indigo-50 transition-all group"
                                >
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                            </svg>
                                        </div>
                                        <div class="text-left">
                                            <p class="font-semibold text-gray-800 group-hover:text-indigo-600">{{ $categoria->nombre }}</p>
                                            <p class="text-xs text-gray-500">{{ $categoria->productos->count() }} productos</p>
                                        </div>
                                    </div>
                                    <svg id="arrow-cat-{{ $categoria->id }}" class="w-5 h-5 text-gray-400 group-hover:text-indigo-600 transition-all transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                
                                <!-- Subproductos -->
                                <div id="productos-cat-{{ $categoria->id }}" class="ml-6 mt-2 space-y-1 hidden">
                                    <button onclick="filterByCategory('cat-{{ $categoria->id }}')" class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all">
                                        • Ver todos ({{ $categoria->productos->count() }})
                                    </button>
                                    @foreach ($categoria->productos as $producto)
                                        <button onclick="scrollToProduct('producto-{{ $producto->id }}')" class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all">
                                            • {{ $producto->nombre }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </nav>

            <!-- Info adicional -->
            <div class="p-4 m-4 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl border border-indigo-200">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-indigo-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-gray-800 mb-1">¿Necesitas ayuda?</p>
                        <p class="text-xs text-gray-600">Contáctanos para cotizaciones personalizadas</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Contenido Principal -->
        <main class="flex-1 p-8 overflow-y-auto">
            <div class="max-w-7xl mx-auto">
                <div class="mb-10">
                    <h1 class="text-5xl font-extrabold text-gray-800 mb-3 bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        Catálogo de Productos
                    </h1>
                    <p class="text-gray-600 text-lg">Descubre nuestra selección de productos listos para comprar</p>
                </div>

                <!-- Mensaje sin resultados -->
                <div id="no-results" class="hidden text-center py-20">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-600 mb-2">No se encontraron productos</h3>
                    <p class="text-gray-500">Intenta con otra búsqueda o categoría</p>
                </div>

                @foreach ($categorias as $categoria)
                    @if ($categoria->productos->count() > 0)
                        <!-- Sección de Categoría -->
                        <div class="mb-16 categoria-section" data-categoria="cat-{{ $categoria->id }}">
                            <div class="flex items-center gap-4 mb-8">
                                <div class="w-1 h-12 bg-gradient-to-b from-indigo-500 to-purple-500 rounded-full"></div>
                                <div>
                                    <h2 class="text-4xl font-bold text-gray-800">{{ $categoria->nombre }}</h2>
                                    <p class="text-gray-500 mt-1">{{ $categoria->productos->count() }} productos disponibles</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                                @foreach ($categoria->productos as $producto)
                                    <div id="producto-{{ $producto->id }}" class="producto-card bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-[1.02] transition-all duration-300 border border-gray-100" data-categoria="cat-{{ $categoria->id }}" data-nombre="{{ strtolower($producto->nombre) }}">
                                        <div class="relative overflow-hidden group">
                                            <a href="{{ route('catalogo.show', $producto->id) }}">
                                                <img 
                                                    src="{{ $producto->imagen ?? 'https://via.placeholder.com/400x300?text=Sin+Imagen' }}" 
                                                    alt="{{ $producto->nombre }}" 
                                                    class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500"
                                                >
                                            </a>
                                        </div>

                                        <div class="p-6">
                                            <h3 class="text-2xl font-bold text-gray-800 mb-2">
                                                {{ $producto->nombre }}
                                            </h3>
                                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $producto->descripcion ?? 'Producto de alta calidad' }}</p>
                                            <div class="flex items-baseline gap-2 mb-4">
                                                <p class="text-3xl font-extrabold text-indigo-600">
                                                    ${{ number_format($producto->precio, 0, ',', '.') }}
                                                </p>
                                            </div>
                                            
                                            <a href="{{ route('catalogo.show', $producto->id) }}" class="group relative block w-full overflow-hidden rounded-xl bg-gradient-to-br from-indigo-600 via-indigo-500 to-purple-600 p-0.5 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                                                <div class="relative bg-white rounded-xl overflow-hidden">
                                                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                                    <div class="relative px-6 py-3 flex items-center justify-center gap-2">
                                                        <svg class="w-5 h-5 text-indigo-600 group-hover:text-purple-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                        <span class="text-base font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent group-hover:from-purple-600 group-hover:to-indigo-600 transition-all duration-300">
                                                            Ver Detalles y Comprar
                                                        </span>
                                                        <svg class="w-5 h-5 text-indigo-600 group-hover:text-purple-600 group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </main>
    </div>

    <script>
        // Toggle categoría (abrir/cerrar lista de productos)
        function toggleCategory(categoryId) {
            const productsDiv = document.getElementById('productos-' + categoryId);
            const arrow = document.getElementById('arrow-' + categoryId);
            
            if (productsDiv.classList.contains('hidden')) {
                productsDiv.classList.remove('hidden');
                arrow.style.transform = 'rotate(180deg)';
            } else {
                productsDiv.classList.add('hidden');
                arrow.style.transform = 'rotate(0deg)';
            }
        }

        // Filtrar por categoría
        function filterByCategory(categoryId) {
            // Ocultar todas las secciones de categoría
            document.querySelectorAll('.categoria-section').forEach(section => {
                section.style.display = 'none';
            });
            
            // Mostrar solo la categoría seleccionada
            const selectedSection = document.querySelector(`[data-categoria="${categoryId}"]`);
            if (selectedSection) {
                selectedSection.style.display = 'block';
            }
            
            // Ocultar mensaje de "no resultados"
            document.getElementById('no-results').classList.add('hidden');
            
            // Scroll suave al inicio
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Mostrar todas las categorías
        function showAllCategories() {
            document.querySelectorAll('.categoria-section').forEach(section => {
                section.style.display = 'block';
            });
            document.getElementById('no-results').classList.add('hidden');
            document.getElementById('searchInput').value = '';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Scroll a producto específico
        function scrollToProduct(productId) {
            // Primero mostrar todas las categorías
            showAllCategories();
            
            // Luego hacer scroll al producto
            setTimeout(() => {
                const element = document.getElementById(productId);
                if (element) {
                    element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    
                    // Efecto de destaque
                    element.classList.add('ring-4', 'ring-indigo-400');
                    setTimeout(() => {
                        element.classList.remove('ring-4', 'ring-indigo-400');
                    }, 2000);
                }
            }, 100);
        }

        // Buscar productos
        function filterProducts() {
            const searchText = document.getElementById('searchInput').value.toLowerCase();
            const products = document.querySelectorAll('.producto-card');
            let hasResults = false;

            if (searchText === '') {
                showAllCategories();
                return;
            }

            products.forEach(product => {
                const productName = product.getAttribute('data-nombre');
                if (productName.includes(searchText)) {
                    product.style.display = 'block';
                    product.closest('.categoria-section').style.display = 'block';
                    hasResults = true;
                } else {
                    product.style.display = 'none';
                }
            });

            // Ocultar categorías vacías
            document.querySelectorAll('.categoria-section').forEach(section => {
                const visibleProducts = section.querySelectorAll('.producto-card[style="display: block;"]');
                if (visibleProducts.length === 0) {
                    section.style.display = 'none';
                }
            });

            // Mostrar mensaje si no hay resultados
            if (!hasResults) {
                document.getElementById('no-results').classList.remove('hidden');
            } else {
                document.getElementById('no-results').classList.add('hidden');
            }
        }
    </script>
</body>
</html>