<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Categoría</title>
    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f9; }
    </style>
</head>
<body class="p-8">

    <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-2xl">
        
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-3xl font-extrabold text-gray-800">Crear Nueva Categoría</h1>
            <a href="{{ route('administracion.categorias.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                ← Volver al Listado
            </a>
        </div>

        <!-- El formulario apunta al método 'store' del CategoriaController -->
        <form action="{{ route('administracion.categorias.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Categoría</label>
                <input type="text" name="nombre" id="nombre" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('nombre') border-red-500 @enderror" value="{{ old('nombre') }}" required>
                @error('nombre')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción (Opcional)</label>
                <textarea name="descripcion" id="descripcion" rows="3" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transition duration-300">
                    Guardar Categoría
                </button>
            </div>
        </form>
    </div>
</body>
</html>