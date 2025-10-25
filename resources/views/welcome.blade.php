<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MM Impresiones | Servicios de Diseño e Impresión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f9; }
        .hero-bg {
            background-image: url('https://picsum.photos/1200/600/?blur=2'); /* Imagen genérica de fondo */
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-2xl font-extrabold text-indigo-700">
                        MM IMPRESIONES
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('catalogo.index') }}" class="text-gray-600 hover:text-indigo-600 font-medium">Catálogo</a>
                    <a href="{{ route('cotizador.index') }}" class="text-gray-600 hover:text-indigo-600 font-medium">Cotizador Rápido</a>
                    
                    @auth
                        <a href="{{ route('home') }}" class="text-white bg-green-500 hover:bg-green-600 px-3 py-1 rounded-lg font-bold transition">Mi Cuenta</a>
                    @else
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Ingresar</a>
                        <a href="{{ route('register') }}" class="text-white bg-indigo-600 hover:bg-indigo-700 px-3 py-1 rounded-lg font-bold transition">Registro</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <header class="hero-bg flex-grow flex items-center justify-center text-center p-8">
        <div class="bg-black bg-opacity-60 p-10 rounded-xl max-w-4xl shadow-2xl backdrop-blur-sm">
            <h1 class="text-6xl font-extrabold text-white mb-4">
                ¡Imprimimos tus Ideas!
            </h1>
            <p class="text-2xl text-gray-200 mb-8">
                Diseño gráfico, impresión digital y soluciones personalizadas al mejor precio.
            </p>
            
            <div class="space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="{{ route('cotizador.index') }}" 
                   class="inline-block bg-yellow-400 text-gray-900 font-bold text-xl py-3 px-8 rounded-lg shadow-xl transition duration-300 hover:bg-yellow-500 transform hover:scale-105">
                    Cotiza Ahora 🚀
                </a>
                <a href="{{ route('catalogo.index') }}" 
                   class="inline-block border-2 border-white text-white font-bold text-xl py-3 px-8 rounded-lg shadow-xl transition duration-300 hover:bg-white hover:text-indigo-700">
                    Ver Catálogo
                </a>
            </div>
        </div>
    </header>

    <footer class="bg-gray-800 text-white p-4 text-center">
        <p>© {{ date('Y') }} MM Impresiones. Todos los derechos reservados.</p>
    </footer>

</body>
</html>