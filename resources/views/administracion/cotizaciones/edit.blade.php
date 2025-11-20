@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 pb-6 border-b-2 border-gray-200">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-800 mb-2">
                        <svg class="w-8 h-8 inline-block text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar Cotización #{{ $cotizacion->id }}
                    </h1>
                    @if($cotizacion->producto)
                        <p class="text-gray-600 ml-10">
                            Para: <span class="font-semibold text-indigo-600">{{ $cotizacion->producto->nombre }}</span>
                        </p>
                    @else
                        <p class="text-gray-600 ml-10">Cotización genérica</p>
                    @endif
                </div>
                
                <a href="{{ route('administracion.cotizaciones.index') }}" 
                   class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition duration-300 shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-lg relative mb-6 shadow-sm">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <strong class="font-bold">¡Atención!</strong>
                            <span class="block sm:inline ml-1">Hay problemas con los datos ingresados:</span>
                            <ul class="list-disc ml-5 mt-2 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-sm">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            
            <form action="{{ route('administracion.cotizaciones.update', $cotizacion) }}" method="POST">
                @csrf
                @method('PUT')

                @if($cotizacion->producto_id)
                    <input type="hidden" name="producto_id" value="{{ $cotizacion->producto_id }}">
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div class="md:col-span-2">
                        <label for="nombre" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Nombre (Identificador)
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="text" name="nombre" id="nombre" required
                               class="block w-full border-2 border-gray-300 rounded-xl shadow-sm p-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('nombre') border-red-500 @enderror" 
                               value="{{ old('nombre', $cotizacion->nombre) }}"
                               placeholder="Ej: Cotización para Cliente X - Proyecto Y">
                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="valor" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Valor Final de Venta ($)
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="number" name="valor" id="valor" required step="0.01" min="0"
                               class="block w-full border-2 border-gray-300 rounded-xl shadow-sm p-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('valor') border-red-500 @enderror" 
                               value="{{ old('valor', $cotizacion->valor) }}"
                               placeholder="15000">
                        @error('valor')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="margen_porcentaje" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Margen (%)
                        </label>
                        <input type="number" name="margen_porcentaje" id="margen_porcentaje" step="0.01" min="0" max="100"
                               class="block w-full border-2 border-gray-300 rounded-xl shadow-sm p-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200" 
                               value="{{ old('margen_porcentaje', $cotizacion->margen_porcentaje) }}"
                               placeholder="15">
                        <p class="mt-1 text-xs text-gray-500">Porcentaje de ganancia sobre el costo</p>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="fecha_validez" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Fecha de Validez
                        </label>
                        <input type="date" name="fecha_validez" id="fecha_validez" 
                               class="block w-full border-2 border-gray-300 rounded-xl shadow-sm p-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200" 
                               value="{{ old('fecha_validez', $cotizacion->fecha_validez ? \Carbon\Carbon::parse($cotizacion->fecha_validez)->format('Y-m-d') : null) }}">
                        <p class="mt-1 text-xs text-gray-500">Fecha hasta la cual es válida esta cotización</p>
                    </div>

                    <div class="md:col-span-2">
                        <label for="notas_cotizacion" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Notas Internas
                        </label>
                        <textarea name="notas_cotizacion" id="notas_cotizacion" rows="4" 
                                  class="block w-full border-2 border-gray-300 rounded-xl shadow-sm p-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200" 
                                  placeholder="Detalles, condiciones o información interna...">{{ old('notas_cotizacion', $cotizacion->notas_cotizacion) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Información que no se mostrará al cliente</p>
                    </div>

                </div>

                <div class="flex gap-4 mt-8 pt-6 border-t-2 border-gray-200">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105 flex items-center justify-center focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-opacity-50">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Guardar Cambios
                    </button>
                    <a href="{{ route('administracion.cotizaciones.index') }}" 
                       class="px-6 py-4 bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold rounded-xl transition duration-300 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancelar
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

