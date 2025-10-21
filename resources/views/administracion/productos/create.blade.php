<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto</title>
    <!-- CDN Tailwind CSS: DEBE ESTAR EN TU LAYOUT PRINCIPAL -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f9; }
    </style>
</head>
<body class="p-8">

    <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-2xl">
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            <h1 class="text-3xl font-extrabold text-gray-800">Crear Nuevo Producto</h1>
            <a href="{{ route('administracion.productos.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold transition duration-300">
                &larr; Volver al Listado
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

        <form action="{{ route('administracion.productos.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Producto</label>
                    <input type="text" name="nombre" id="nombre" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('nombre') }}" required>
                </div>

                <!-- Categoría -->
                <div>
                    <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                    <select name="categoria_id" id="categoria_id" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="">Seleccione una categoría</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}" @selected(old('categoria_id') == $categoria->id)>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Precio -->
                <div>
                    <label for="precio" class="block text-sm font-medium text-gray-700 mb-1">Precio ($)</label>
                    <input type="number" step="0.01" name="precio" id="precio" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('precio') }}" required>
                </div>

                <!-- Stock -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                    <input type="number" name="stock" id="stock" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('stock', 0) }}" required>
                </div>

                <!-- Descripción -->
                <div class="md:col-span-2">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500">{{ old('descripcion') }}</textarea>
                </div>

                <!-- Imagen (Campo simulado, se necesitaría configuración para la subida) -->
                <div class="md:col-span-2">
                    <label for="imagen" class="block text-sm font-medium text-gray-700 mb-1">URL de Imagen (Opcional)</label>
                    <input type="text" name="imagen" id="imagen" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('imagen') }}">
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
                    Guardar Producto
                </button>
            </div>
        </form>
    </div>
</body>
</html>
