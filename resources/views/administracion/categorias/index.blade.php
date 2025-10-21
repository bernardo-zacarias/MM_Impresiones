<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorías</title>
    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f9; }
    </style>
</head>
<body class="p-8">

    <!-- Mensaje de éxito al crear/editar/eliminar -->
    @if (session('success'))
        <div class="max-w-6xl mx-auto bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6 shadow-md" role="alert">
            <strong class="font-bold">¡Éxito!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="max-w-6xl mx-auto bg-white p-6 rounded-xl shadow-2xl">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-3xl font-extrabold text-gray-800">Gestión de Categorías</h1>
            <a href="{{ route('administracion.categorias.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
                Crear Nueva Categoría
            </a>
        </div>

        <div class="overflow-x-auto">
            <!-- La variable $categorias debe ser pasada desde el CategoriaController::index -->
            @isset($categorias)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($categorias as $categoria)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $categoria->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $categoria->nombre }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">{{ $categoria->descripcion ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('administracion.categorias.edit', $categoria->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                                    
                                    <form action="{{ route('administracion.categorias.destroy', $categoria->id) }}" method="POST" class="inline-block" >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    No se encontraron categorías.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @else
                <p class="text-center text-gray-500">Esperando datos del controlador...</p>
            @endisset
        </div>

        <!-- Paginación (si el controlador usa paginate()) -->
        @if (isset($categorias) && $categorias->hasPages())
            <div class="mt-4">
                {{ $categorias->links() }}
            </div>
        @endif
    </div>
</body>
</html>