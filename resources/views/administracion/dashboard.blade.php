<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración | Dashboard</title>
    <!-- Incluimos Tailwind CSS para estilos -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f9; }
    </style>
</head>
<body class="p-8">

    <div class="max-w-6xl mx-auto bg-white p-8 rounded-xl shadow-2xl">
        
        <!-- Encabezado y Menú -->
        <header class="flex justify-between items-center mb-10 border-b pb-4">
            <h1 class="text-4xl font-extrabold text-indigo-700">Panel de Administración</h1>
            
            <nav class="flex space-x-4">
                <a href="{{ route('administracion.dashboard') }}" class="px-3 py-2 text-white bg-indigo-600 rounded-lg font-medium shadow-md">Dashboard</a>
                <a href="{{ route('administracion.categorias.index') }}" class="px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg font-medium">Categorías</a>
                <a href="{{ route('administracion.productos.index') }}" class="px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg font-medium">Productos</a>
                
                <!-- Formulario de Logout (muy importante) -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg font-medium transition duration-150">
                        Cerrar Sesión ({{ Auth::user()->name }})
                    </button>
                </form>
            </nav>
        </header>

        <!-- Contenido Principal del Dashboard -->
        <main>
            <div class="text-center bg-green-50 border border-green-200 p-6 rounded-xl mb-8">
                <h2 class="text-2xl font-semibold text-green-700">¡Bienvenido, {{ Auth::user()->name }}!</h2>
                <p class="text-green-600 mt-2">Estás en el panel de control con rol de **Administrador**.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Tarjeta 1: Categorías -->
                <div class="bg-indigo-50 border border-indigo-200 p-6 rounded-xl shadow-md">
                    <h3 class="text-xl font-bold text-indigo-700 mb-2">Gestión de Categorías</h3>
                    <p class="text-indigo-600">Administra los tipos de productos (Ej: Muebles, Iluminación).</p>
                    <a href="{{ route('administracion.categorias.index') }}" class="mt-4 inline-block text-sm font-semibold text-indigo-600 hover:text-indigo-800">Ir a Categorías &rarr;</a>
                </div>

                <!-- Tarjeta 2: Productos -->
                <div class="bg-pink-50 border border-pink-200 p-6 rounded-xl shadow-md">
                    <h3 class="text-xl font-bold text-pink-700 mb-2">Gestión de Productos</h3>
                    <p class="text-pink-600">Crea, edita o elimina los productos de tu inventario.</p>
                    <a href="{{ route('administracion.productos.index') }}" class="mt-4 inline-block text-sm font-semibold text-pink-600 hover:text-pink-800">Ir a Productos &rarr;</a>
                </div>

                <!-- Tarjeta 3: Otros Módulos (Simulado) -->
                <div class="bg-gray-50 border border-gray-200 p-6 rounded-xl shadow-md">
                    <h3 class="text-xl font-bold text-gray-700 mb-2">Módulos Futuros</h3>
                    <p class="text-gray-600">Cotizaciones, Pedidos, Usuarios y Reportes (próximamente).</p>
                    <span class="mt-4 inline-block text-sm font-semibold text-gray-500">En desarrollo</span>
                </div>
            </div>
        </main>

    </div>

</body>
</html>
