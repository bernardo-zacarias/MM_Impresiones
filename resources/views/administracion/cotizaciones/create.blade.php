<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- El título se adapta si se recibe la variable $producto --}}
    <title>Crear Cotización @isset($producto) para {{ $producto->nombre }} @endisset</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f9; }
    </style>
</head>
<body class="p-8">

    <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-2xl">
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            
            <h1 class="text-3xl font-extrabold text-gray-800">
                Nuevo Producto de Cotización 
                {{-- Muestra el nombre del producto solo si la variable existe --}}
                @isset($producto)
                    para: <span class="text-indigo-600">{{ $producto->nombre }}</span>
                @else
            
                @endisset
            </h1>
            
            <a href="{{ route('administracion.cotizaciones.index') }}" class="text-gray-600 hover:text-gray-800 font-semibold transition duration-300">
                &larr; Volver a Cotizaciones
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- El formulario apunta a la ruta 'store' donde el Controller inyecta el usuario_id --}}
        <form action="{{ route('administracion.cotizaciones.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- CAMPO OCULTO: ID del Producto. Si existe $producto, se envía su ID. --}}
            @isset($producto)
                <input type="hidden" name="producto_id" value="{{ $producto->id }}">
            @endisset

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Nombre/Concepto -->
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre o Concepto <span class="text-red-500">*</span></label>
                    <input type="text" name="nombre" id="nombre" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('nombre') }}" required>
                </div>

                <!-- Valor -->
                <div>
                    <label for="valor" class="block text-sm font-medium text-gray-700 mb-1">Valor Unitario <span class="text-red-500">*</span></label>
                    <input type="number" name="valor" id="valor" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('valor') }}" required>
                </div>

                <!-- Margen Porcentaje -->
                <div>
                    <label for="margen_porcentaje" class="block text-sm font-medium text-gray-700 mb-1">Margen (%) (Opcional)</label>
                    <input type="number" name="margen_porcentaje" id="margen_porcentaje" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('margen_porcentaje') }}">
                </div>
                
                <!-- Fecha Validez -->
                <div>
                    <label for="fecha_validez" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Validez (Opcional)</label>
                    <input type="date" name="fecha_validez" id="fecha_validez" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('fecha_validez') }}">
                </div>

                <!-- Notas Cotización -->
                <div class="md:col-span-2">
                    <label for="notas_cotizacion" class="block text-sm font-medium text-gray-700 mb-1">Notas Internas de la Cotización</label>
                    <textarea name="notas_cotizacion" id="notas_cotizacion" rows="3" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500">{{ old('notas_cotizacion') }}</textarea>
                </div>

            </div>

            <div class="mt-8">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg shadow-xl transition duration-300 transform hover:scale-[1.01]">
                    Guardar Producto de Cotización
                </button>
            </div>
        </form>

    </div>
</body>
</html>
