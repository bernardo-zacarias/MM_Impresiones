@extends('layouts.app')

@section('title', 'Editar Producto: ' . $producto->nombre)

@section('content')

    <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-2xl">
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            <h1 class="text-3xl font-extrabold text-gray-800">Editar Producto: <span class="text-indigo-600">{{ $producto->nombre }}</span></h1>
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

        {{-- CAMBIO CLAVE 1: Agregamos enctype="multipart/form-data" para la subida de archivos --}}
        <form action="{{ route('administracion.productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Producto</label>
                    <input type="text" name="nombre" id="nombre" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('nombre', $producto->nombre) }}" required>
                </div>

                <div>
                    <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                    <select name="categoria_id" id="categoria_id" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="">Seleccione una categoría</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}" @selected(old('categoria_id', $producto->categoria_id) == $categoria->id)>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="precio" class="block text-sm font-medium text-gray-700 mb-1">Precio ($)</label>
                    <input type="number" step="0.01" name="precio" id="precio" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('precio', $producto->precio) }}" required>
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                    <input type="number" name="stock" id="stock" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('stock', $producto->stock) }}" required>
                </div>

                <div class="md:col-span-2">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500">{{ old('descripcion', $producto->descripcion) }}</textarea>
                </div>
            
                {{-- CAMBIO CLAVE 2: Mostrar imagen actual y permitir reemplazo/eliminación --}}
                <div class="md:col-span-2 mt-4">
                    <label for="imagen" class="block text-sm font-medium text-gray-700 mb-2">Imagen del Producto (Max 2MB)</label>
                    
                    @if ($producto->imagen)
                        <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 p-4 bg-gray-50 rounded-lg mb-4 border">
                            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen actual de {{ $producto->nombre }}" class="w-32 h-32 object-cover rounded-lg border-2 border-indigo-200 shadow-md">
                            
                            <div class="flex items-center">
                                <input 
                                    type="checkbox" 
                                    name="delete_imagen" 
                                    value="1" 
                                    id="delete_imagen" 
                                    class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500 w-5 h-5"
                                >
                                <label for="delete_imagen" class="ml-2 text-base text-red-700 font-semibold cursor-pointer">
                                    Eliminar imagen actual
                                </label>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 mb-3">No hay imagen subida para este producto.</p>
                    @endif
                    
                    <label for="imagen" class="block text-sm font-medium text-gray-700 mb-1">Subir nueva imagen (Reemplazará la actual si no marca "Eliminar")</label>
                    <input 
                        type="file" 
                        name="imagen" 
                        id="imagen" 
                        accept=".jpeg,.png,.jpg,.gif,.svg"
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
                    Actualizar Producto
                </button>
            </div>
        </form>
    </div>
@endsection