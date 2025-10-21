<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Precios de Cotización</title>
    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f9; }
        /* Estilo para que la paginación de Laravel se vea bien con Tailwind */
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
</head>
<body class="p-8">

    <div class="max-w-7xl mx-auto bg-white p-6 rounded-xl shadow-2xl">

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6 shadow-md" role="alert">
                <strong class="font-bold">¡Éxito!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-3xl font-extrabold text-gray-800">Gestión de Precios de Cotización</h1>
            <!-- Botón para crear una cotización genérica -->
            <a href="{{ route('administracion.cotizaciones.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Nuevo Producto de Cotización
            </a>
        </div>

        <div class="overflow-x-auto shadow-lg rounded-xl">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre Cotización</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto Asociado</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor (€)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Margen (%)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Validez</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($cotizaciones as $cotizacion)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $cotizacion->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $cotizacion->nombre }}</td>
                            
                            <!-- Columna del Producto Asociado (Usa la relación 'producto' en el modelo Cotizacion) -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                @if ($cotizacion->producto)
                                    <span class="font-semibold text-indigo-700">{{ $cotizacion->producto->nombre }}</span>
                                @else
                                    <span class="text-gray-400 italic">No asociado</span>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                €{{ number_format($cotizacion->valor, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $cotizacion->margen_porcentaje ?? 'N/A' }}%
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $cotizacion->fecha_validez ? \Carbon\Carbon::parse($cotizacion->fecha_validez)->format('d/m/Y') : 'Sin límite' }}
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('administracion.cotizaciones.edit', $cotizacion->id) }}" class="text-green-600 hover:text-green-900 mr-3 transition duration-150">Editar</a>
                                <form action="{{ route('administracion.cotizaciones.destroy', $cotizacion->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta cotización? Esta acción es irreversible.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 transition duration-150">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-lg font-semibold text-gray-500 bg-gray-50">
                                No se encontraron precios de cotización registrados. ¡Crea el primero!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <!-- Paginación: Usa la variable $cotizaciones -->
            {{ $cotizaciones->links() }}
        </div>

    </div>
</body>
</html>
