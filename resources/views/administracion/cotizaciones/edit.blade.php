<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoría</title>
    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f9; }
    </style>
</head>
<body class="p-8">

    <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-2xl">
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            <h1 class="text-3xl font-extrabold text-gray-800">
                Editar Categoría: <span class="text-indigo-600">{{ $categoria->nombre }}</span>
            </h1>
            <a href="{{ route('administracion.categorias.index') }}" class="text-gray-600 hover:text-gray-800 font-semibold transition duration-300">
                &larr; Volver a Categorías
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
        <form action="{{ route('administracion.categorias.update', $categoria->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Método necesario para el recurso RESTful UPDATE --}}

            <div class="space-y-6">
                
                {{-- Campo Nombre de la Categoría --}}
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Categoría</label>
                    <input 
                        type="text" 
                        name="nombre" 
                        id="nombre" 
                        required
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('nombre') border-red-500 @enderror" 
                        value="{{ old('nombre', $categoria->nombre) }}"
                        placeholder="Ej: Iluminación LED, Componentes, etc."
                    >
                    @error('nombre')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo Descripción (Opcional) --}}
                <div>
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción (Opcional)</label>
                    <textarea 
                        name="descripcion" 
                        id="descripcion" 
                        rows="3" 
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Detalles sobre el tipo de productos que abarca esta categoría..."
                    >{{ old('descripcion', $categoria->descripcion) }}</textarea>
                </div>

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
