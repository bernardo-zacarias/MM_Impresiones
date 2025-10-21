<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cotización #{{ $cotizacion->id }}</title>
    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f9; }
    </style>
</head>
<body class="p-8">

    <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-2xl">
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            <h1 class="text-3xl font-extrabold text-gray-800">
                Editar Cotización #{{ $cotizacion->id }}
                @if($cotizacion->producto)
                    para: <span class="text-indigo-600">{{ $cotizacion->producto->nombre }}</span>
                @else
                    (Genérica)
                @endif
            </h1>
            <a href="{{ route('administracion.cotizaciones.index') }}" class="text-gray-600 hover:text-gray-800 font-semibold transition duration-300">
                &larr; Volver a Cotizaciones
            </a>
        </div>

        {{-- Bloque para mostrar errores de validación --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6">
                <strong class="font-bold">¡Ouch!</strong>
                <span class="block sm:inline">Hay problemas con los datos ingresados:</span>
                <ul class="list-disc ml-5 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        {{-- Formulario de Edición --}}
        {{-- CORRECCIÓN CLAVE: Pasamos el objeto modelo completo $cotizacion a la ruta --}}
        <form action="{{ route('administracion.cotizaciones.update', $cotizacion) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Campo Nombre de la Cotización --}}
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre (Identificador de la Cotización)</label>
                    <input 
                        type="text" 
                        name="nombre" 
                        id="nombre" 
                        required
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('nombre') border-red-500 @enderror" 
                        value="{{ old('nombre', $cotizacion->nombre) }}"
                        placeholder="Ej: Cotización para Cliente X - Proyecto Y"
                    >
                    @error('nombre')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo Valor Final --}}
                <div>
                    <label for="valor" class="block text-sm font-medium text-gray-700 mb-1">Valor Final de Venta ($)</label>
                    <input 
                        type="number" 
                        name="valor" 
                        id="valor" 
                        required
                        step="0.01" 
                        min="0"
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('valor') border-red-500 @enderror" 
                        value="{{ old('valor', $cotizacion->valor) }}"
                        placeholder="199.99"
                    >
                    @error('valor')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Margen de Porcentaje --}}
                <div>
                    <label for="margen_porcentaje" class="block text-sm font-medium text-gray-700 mb-1">Margen (%)</label>
                    <input 
                        type="number" 
                        name="margen_porcentaje" 
                        id="margen_porcentaje" 
                        step="0.01" 
                        min="0" 
                        max="100"
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" 
                        value="{{ old('margen_porcentaje', $cotizacion->margen_porcentaje) }}"
                        placeholder="15"
                    >
                </div>
                
                {{-- Fecha Validez --}}
                <div>
                    <label for="fecha_validez" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Validez (Opcional)</label>
                    <input 
                        type="date" 
                        name="fecha_validez" 
                        id="fecha_validez" 
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" 
                        {{-- Usamos el formato 'Y-m-d' que requiere el input type="date" --}}
                        value="{{ old('fecha_validez', $cotizacion->fecha_validez ? \Carbon\Carbon::parse($cotizacion->fecha_validez)->format('Y-m-d') : null) }}"
                    >
                </div>

                {{-- Notas Cotización --}}
                <div class="md:col-span-2">
                    <label for="notas_cotizacion" class="block text-sm font-medium text-gray-700 mb-1">Notas Internas de la Cotización</label>
                    <textarea 
                        name="notas_cotizacion" 
                        id="notas_cotizacion" 
                        rows="3" 
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Detalles, condiciones o información interna."
                    >{{ old('notas_cotizacion', $cotizacion->notas_cotizacion) }}</textarea>
                </div>

                {{-- Campo Oculto para mantener el producto_id si existe --}}
                @if($cotizacion->producto_id)
                    <input type="hidden" name="producto_id" value="{{ $cotizacion->producto_id }}">
                @endif

            </div>

            <div class="mt-8">
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition duration-300 transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-opacity-50">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</body>
</html>

