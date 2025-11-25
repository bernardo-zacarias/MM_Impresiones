@extends('layouts.app')

@section('title', 'Catálogo de Productos')

{{-- Usamos la sección 'content' para el diseño principal --}}
@section('content')

    <div class="flex flex-col lg:flex-row min-h-screen -mt-8"> {{-- -mt-8 ajusta el espacio del header --}}
        <!-- Mobile Category Toggle Button -->
        <button 
            id="mobile-category-toggle" 
            class="lg:hidden fixed bottom-4 right-4 z-50 bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-4 rounded-full shadow-2xl hover:shadow-3xl transition-all"
            onclick="toggleMobileCategories()"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <aside id="mobile-categories" class="hidden lg:block lg:w-80 bg-white shadow-2xl lg:sticky lg:top-0 h-screen overflow-y-auto border-r-4 border-indigo-200 fixed inset-0 z-40" style="top: 64px;"> {{-- top: 64px (h-16 del header) --}}
            <div class="p-6 bg-gradient-to-br from-indigo-600 to-purple-600">
                <h2 class="text-2xl font-bold text-white mb-2 flex items-center gap-2">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                    Categorías
                </h2>
                <p class="text-indigo-100 text-sm">Explora nuestros productos</p>
            </div>

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

            <nav class="p-4">
                <div class="space-y-2">
                    {{-- Verifica si $categorias existe y tiene productos asociados --}}
                    @if (isset($categorias)) 
                        @foreach ($categorias as $index => $categoria)
                            @if (isset($categoria->productos) && $categoria->productos->count() > 0)
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
                    @else 
                        <p class="p-3 text-center text-gray-500 italic">No hay categorías disponibles.</p>
                    @endif
                </div>
            </nav>

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

        <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto">
            <div class="max-w-7xl mx-auto">
                <div class="mb-6 sm:mb-10">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-800 mb-2 sm:mb-3 bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        Catálogo de Productos
                    </h1>
                    <p class="text-gray-600 text-sm sm:text-base lg:text-lg">Descubre nuestra selección de productos listos para comprar</p>
                </div>

                <div id="no-results" class="hidden text-center py-20">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-600 mb-2">No se encontraron productos</h3>
                    <p class="text-gray-500">Intenta con otra búsqueda o categoría</p>
                </div>

                @if (isset($categorias))
                    @foreach ($categorias as $categoria)
                        @if (isset($categoria->productos) && $categoria->productos->count() > 0)
                            <div class="mb-10 sm:mb-16 categoria-section" data-categoria="cat-{{ $categoria->id }}">
                                <div class="flex items-center gap-3 sm:gap-4 mb-6 sm:mb-8">
                                    <div class="w-1 h-8 sm:h-12 bg-gradient-to-b from-indigo-500 to-purple-500 rounded-full"></div>
                                    <div>
                                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-800">{{ $categoria->nombre }}</h2>
                                        <p class="text-gray-500 mt-1 text-sm sm:text-base">{{ $categoria->productos->count() }} productos disponibles</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
                                    @foreach ($categoria->productos as $producto)
                                        <div id="producto-{{ $producto->id }}" class="producto-card bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-[1.02] transition-all duration-300 border border-gray-100" data-categoria="cat-{{ $categoria->id }}" data-nombre="{{ strtolower($producto->nombre) }}">
                                            <div class="relative overflow-hidden group">
                                                <a href="{{ route('catalogo.show', $producto->id) }}">
                                                    {{-- CAMBIO CLAVE AQUÍ: Usamos asset('storage/...') para las imágenes subidas --}}
                                                    <img 
                                                        src="{{ $producto->imagen ? asset('storage/' . $producto->imagen) : 'https://via.placeholder.com/400x300?text=Sin+Imagen' }}" 
                                                        alt="{{ $producto->nombre }}" 
                                                        class="w-full h-40 sm:h-48 lg:h-56 object-cover group-hover:scale-110 transition-transform duration-500"
                                                    >
                                                </a>
                                            </div>

                                            <div class="p-4 sm:p-5 lg:p-6">
                                                <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-800 mb-2">
                                                    {{ $producto->nombre }}
                                                </h3>
                                                <p class="text-gray-600 text-xs sm:text-sm mb-3 sm:mb-4 line-clamp-2">{{ $producto->descripcion ?? 'Producto de alta calidad' }}</p>
                                                <div class="flex items-baseline gap-2 mb-3 sm:mb-4">
                                                    <p class="text-2xl sm:text-3xl font-extrabold text-indigo-600">
                                                        ${{ number_format($producto->precio, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                                
                                                <a href="{{ route('catalogo.show', $producto->id) }}" class="group relative block w-full overflow-hidden rounded-xl bg-gradient-to-br from-indigo-600 via-indigo-500 to-purple-600 p-0.5 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                                                    <div class="relative bg-white rounded-xl overflow-hidden">
                                                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                                        <div class="relative px-4 py-2 sm:px-6 sm:py-3 flex items-center justify-center gap-2">
                                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-indigo-600 group-hover:text-purple-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                            </svg>
                                                            <span class="text-sm sm:text-base font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent group-hover:from-purple-600 group-hover:to-indigo-600 transition-all duration-300">
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
                @endif
            </div>
        </main>
    </div>

@endsection

{{-- JS Mantenido sin cambios --}}
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
        document.querySelectorAll('.producto-card').forEach(card => {
            card.style.display = 'block';
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
                element.classList.add('ring-4', 'ring-indigo-400', 'ring-offset-4');
                setTimeout(() => {
                    element.classList.remove('ring-4', 'ring-indigo-400', 'ring-offset-4');
                }, 2000);
            }
        }, 100);
    }

    // Buscar productos
    function filterProducts() {
        const searchText = document.getElementById('searchInput').value.toLowerCase();
        const productCards = document.querySelectorAll('.producto-card');
        let hasResults = false;

        if (searchText === '') {
            showAllCategories();
            return;
        }

        // 1. Mostrar/Ocultar tarjetas de productos
        productCards.forEach(product => {
            const productName = product.getAttribute('data-nombre');
            if (productName.includes(searchText)) {
                product.style.display = 'block';
                hasResults = true;
            } else {
                product.style.display = 'none';
            }
        });

        // 2. Mostrar/Ocultar secciones de categorías
        document.querySelectorAll('.categoria-section').forEach(section => {
            // Contar productos visibles dentro de esta sección
            const visibleProducts = section.querySelectorAll('.producto-card[style="display: block;"]').length;
            
            if (visibleProducts > 0) {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        });

        // 3. Mostrar mensaje de "no resultados"
        if (!hasResults) {
            document.getElementById('no-results').classList.remove('hidden');
        } else {
            document.getElementById('no-results').classList.add('hidden');
        }
    }

    // Toggle categorías en móvil
    function toggleMobileCategories() {
        const sidebar = document.querySelector('aside');
        const toggleButton = document.getElementById('mobile-category-toggle');
        
        if (sidebar.classList.contains('hidden')) {
            sidebar.classList.remove('hidden');
            sidebar.classList.add('fixed', 'inset-0', 'z-40', 'bg-white', 'overflow-y-auto');
            toggleButton.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
        } else {
            sidebar.classList.add('hidden');
            sidebar.classList.remove('fixed', 'inset-0', 'z-40', 'overflow-y-auto');
            toggleButton.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>';
        }
    }
</script>