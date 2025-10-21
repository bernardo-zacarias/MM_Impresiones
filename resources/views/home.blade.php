<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f9; }
    </style>
</head>
<body class="p-8">

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-2xl text-center">
        
        <!-- Muestra el mensaje de éxito del registro o el error del middleware -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6">
                {{ session('success') }}
            </div>
        @endif
        
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6">
                {{ session('error') }}
            </div>
        @endif

        @auth
            <!-- Contenido para usuarios autenticados -->
            <h1 class="text-4xl font-extrabold text-indigo-600 mb-4">
                Bienvenido, {{ Auth::user()->name }}
            </h1>
            <p class="text-xl text-gray-700 mb-8">
                Tu rol actual es: <span class="font-bold uppercase text-red-500">{{ Auth::user()->rol }}</span>
            </p>

            <div class="flex flex-col space-y-4">
                @if (Auth::user()->rol === 'admin')
                    <!-- Enlace para Administradores -->
                    <p class="text-lg text-gray-600">Tienes acceso total al panel de administración.</p>
                    <a href="{{ route('administracion.categorias.index') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-xl shadow-md transition duration-300 transform hover:scale-[1.01]">
                        Ir al Panel de Administración
                    </a>
                @else
                    <!-- Enlace para Clientes (Rol por defecto) -->
                    <p class="text-lg text-gray-600">
                        Como cliente, esta es tu zona principal. Pronto podrás ver productos.
                    </p>
                    <a href="#" class="bg-indigo-500 text-white font-bold py-3 px-6 rounded-xl shadow-md transition duration-300 opacity-70 cursor-not-allowed">
                        Ver Catálogo de Productos
                    </a>
                @endif

                <!-- Formulario de Logout -->
                <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-900 transition duration-300 underline">
                        Cerrar Sesión
                    </button>
                </form>
            </div>

        @else
            <!-- Contenido para usuarios NO autenticados -->
            <h1 class="text-4xl font-extrabold text-gray-800 mb-6">
                Sistema de Tienda
            </h1>
            <p class="text-lg text-gray-600 mb-8">
                ¡Registra tu cuenta de cliente hoy!
            </p>
            <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition duration-300">
                Registrarse
            </a>
            <p class="mt-4 text-sm text-gray-500">
                (Si ya tienes cuenta, necesitas la ruta de login)
            </p>
        @endauth
    </div>
</body>
</html>
