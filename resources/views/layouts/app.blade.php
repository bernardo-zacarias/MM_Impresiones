
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MM Impresiones - @yield('title', 'Servicios de Diseño e Impresión Profesional')</title> 
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            /* Se mantiene el fondo de la Home, pero es mejor definirlo en el @section('content') de la Home 
               para no forzarlo en páginas de administración que podrían ser blancas.
               Dejaremos el fondo general en el body como un color claro simple.
            */
            background-color: #f4f7f9; 
        }
        /* Animación y estilos de la Home */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Estilos de paginación para la Administración (mantener consistencia) */
        .pagination { display: flex; list-style: none; padding: 0; }
        .pagination li { margin: 0 4px; }
        .pagination li span, .pagination li a { 
            padding: 8px 12px; 
            border: 1px solid #e5e7eb; 
            border-radius: 0.5rem; 
            text-decoration: none; 
            color: #4b5563; 
            transition: all 0.2s;
        }
        .pagination li a:hover { 
            background-color: #f3f4f6; 
            border-color: #d1d5db;
        }
        .pagination .active span { 
            background-color: #4f46e5; /* indigo-600 */
            color: white; 
            border-color: #4f46e5;
        }
    </style>
    @yield('styles') 
</head>

<body class="flex flex-col min-h-screen">

    {{-- ======================================================= --}}
    {{-- ENCABEZADO (HEADER) - Tomado de tu página principal --}}
    {{-- ======================================================= --}}
    <nav class="bg-white shadow-lg sticky top-0 z-50 border-b-4 border-indigo-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                <div class="flex items-center gap-3">
                    {{-- **CAMBIO AQUÍ** - Insertamos la imagen del logo en lugar del SVG --}}
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <img 
                            src="{{ asset('images/assets/logo.enc') }}" 
                            alt="Logo MM Impresiones" 
                            class="w-12 h-12 rounded-xl shadow-lg object-contain"
                        >
                        <span class="text-3xl font-extrabold gradient-text">
                            MM IMPRESIONES
                        </span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('catalogo.index') }}" class="text-gray-700 hover:text-indigo-600 font-semibold transition-all flex items-center gap-2 group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        Catálogo
                    </a>
                    <a href="{{ route('cotizador.index') }}" class="text-gray-700 hover:text-indigo-600 font-semibold transition-all flex items-center gap-2 group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        Cotizador
                    </a>
                    
                    {{-- Lógica de autenticación que debe estar aquí --}}
                    @auth
                        {{-- Botón Admin solo para administradores --}}
                        @if(auth()->user()->rol === 'admin')
                            <a href="{{ route('administracion.dashboard') }}" class="group relative block overflow-hidden rounded-xl bg-gradient-to-br from-red-600 to-pink-600 p-0.5 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                <div class="relative bg-gradient-to-br from-red-600 to-pink-600 rounded-xl overflow-hidden">
                                    <div class="relative px-6 py-2 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span class="font-bold text-white">Admin</span>
                                        @php
                                            $pedidosPendientes = \App\Models\Pedido::whereIn('estado', ['pendiente', 'pagado'])->count();
                                        @endphp
                                        @if($pedidosPendientes > 0)
                                            <span class="absolute -top-1 -right-1 bg-yellow-400 text-gray-900 text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center animate-pulse">
                                                {{ $pedidosPendientes }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endif
                        
                        <a href="{{ route('home') }}" class="group relative block overflow-hidden rounded-xl bg-gradient-to-br from-green-600 to-emerald-600 p-0.5 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <div class="relative bg-gradient-to-br from-green-600 to-emerald-600 rounded-xl overflow-hidden">
                                <div class="relative px-6 py-2 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span class="font-bold text-white">Mi Cuenta</span>
                                </div>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold transition-all">
                            Ingresar
                        </a>
                        <a href="{{ route('register') }}" class="group relative block overflow-hidden rounded-xl bg-gradient-to-br from-indigo-600 to-purple-600 p-0.5 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <div class="relative bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl overflow-hidden">
                                <div class="relative px-6 py-2 flex items-center gap-2">
                                    <span class="font-bold text-white">Registrarse</span>
                                    <svg class="w-4 h-4 text-white group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>


    {{-- ======================================================= --}}
    {{-- CONTENIDO PRINCIPAL (Aquí se inyectará el contenido de las vistas) --}}
    {{-- La clase "flex-grow" asegura que el footer siempre esté al final --}}
    {{-- ======================================================= --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- ======================================================= --}}
    {{-- PIE DE PÁGINA (FOOTER) - Tomado de tu página principal --}}
    {{-- ======================================================= --}}
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3">
                    {{-- **CAMBIO AQUÍ** - Insertamos la imagen del logo en lugar del SVG --}}
                        <a href="{{ url('/') }}" class="flex items-center gap-3">
                            <img 
                                src="{{ asset('images/assets/logo.enc') }}" 
                                alt="Logo MM Impresiones" 
                                class="w-12 h-12 rounded-xl shadow-lg object-contain"
                            >
                            <span class="text-3xl font-extrabold gradient-text">
                                MM IMPRESIONES
                            </span>
                        </a>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Tu socio confiable en diseño e impresión. Transformamos ideas en realidad con calidad excepcional y servicio personalizado.
                    </p>
                    <div class="flex gap-4">
                        <a href="https://www.facebook.com/bernardo.saavedra.675247" class="w-10 h-10 bg-gray-800 hover:bg-indigo-600 rounded-lg flex items-center justify-center transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-indigo-600 rounded-lg flex items-center justify-center transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-indigo-600 rounded-lg flex items-center justify-center transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Enlaces Rápidos</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('catalogo.index') }}" class="text-gray-400 hover:text-indigo-400 transition-colors">Catálogo</a>
                        </li>
                        <li>
                            <a href="{{ route('cotizador.index') }}" class="text-gray-400 hover:text-indigo-400 transition-colors">Cotizador</a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-indigo-400 transition-colors">Servicios</a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-indigo-400 transition-colors">Sobre Nosotros</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Contacto</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-2 text-gray-400">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            +56 9 3063 4435
                        </li>
                        <li class="flex items-center gap-2 text-gray-400">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            info@mmimpresiones.com
                        </li>
                        <li class="flex items-start gap-2 text-gray-400">
                            <svg class="w-5 h-5 text-indigo-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Santiago, Chile
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-gray-400 text-sm">
                        © {{ date('Y') }} MM Impresiones. Todos los derechos reservados.
                    </p>
                    <div class="flex gap-6 text-sm text-gray-400">
                        <a href="#" class="hover:text-indigo-400 transition-colors">Política de Privacidad</a>
                        <a href="#" class="hover:text-indigo-400 transition-colors">Términos y Condiciones</a>
                        <a href="#" class="hover:text-indigo-400 transition-colors">FAQ</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>