<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizador de Trabajos - MM Impresiones</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
@extends('layouts.app')

<body class="bg-gradient-to-br from-gray-50 to-indigo-50 min-h-screen">

    <div class="max-w-7xl mx-auto p-8">

        <!-- Header -->
        <div class="mb-10">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-1 h-16 bg-gradient-to-b from-purple-500 to-pink-500 rounded-full"></div>
                <div>
                    <h1 class="text-5xl font-extrabold text-gray-800 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                        Calculadora de Cotización
                    </h1>
                    <p class="text-gray-600 text-lg mt-2">Obtén un presupuesto personalizado en tiempo real</p>
                </div>
            </div>
        </div>

        <!-- Mensajes de Éxito/Error -->
        @if (session('success'))
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 px-6 py-4 rounded-xl relative mb-8 shadow-lg">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <strong class="font-bold text-green-800">¡Genial!</strong>
                        <span class="block sm:inline text-green-700">{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif
        
        @if ($errors->any())
            <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 px-6 py-4 rounded-xl mb-8 shadow-lg">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="font-bold text-red-800 mb-2">⚠️ Por favor, corrige los siguientes errores:</p>
                        <ul class="list-disc ml-5 text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- SECCIÓN IZQUIERDA: Formulario --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- 1. SELECCIÓN DE TRABAJO --}}
                <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-xl">1</span>
                        </div>
                        <label for="tipo_trabajo" class="text-2xl font-bold text-gray-800">
                            Tipo de Trabajo
                        </label>
                    </div>
                    
                    <select id="tipo_trabajo" 
                            class="w-full border-2 border-gray-300 rounded-xl shadow-sm p-4 text-lg focus:ring-4 focus:ring-purple-200 focus:border-purple-500 transition-all">
                        <option value="" data-valor="0">Selecciona un tipo de trabajo...</option>
                        @foreach($productosCotizables as $producto)
                            <option 
                                value="{{ $producto['id'] }}" 
                                data-valor="{{ $producto['valor_base'] }}" 
                                data-nombre="{{ $producto['nombre'] }}"
                            >
                                {{ $producto['nombre'] }} (${{ number_format($producto['valor_base'], 2) }} por m²)
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 2. DIMENSIONES Y CANTIDAD --}}
                <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-xl">2</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">
                            Dimensiones y Cantidad
                        </h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="alto" class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                                </svg>
                                Alto (metros)
                            </label>
                            <input type="number" id="alto" min="0.01" step="0.01" value="1.00"
                                class="w-full border-2 border-gray-300 rounded-xl p-3 text-center text-lg font-semibold focus:ring-4 focus:ring-purple-200 focus:border-purple-500 transition-all"
                                placeholder="1.00">
                        </div>
                        <div>
                            <label for="ancho" class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                                Ancho (metros)
                            </label>
                            <input type="number" id="ancho" min="0.01" step="0.01" value="1.00"
                                class="w-full border-2 border-gray-300 rounded-xl p-3 text-center text-lg font-semibold focus:ring-4 focus:ring-purple-200 focus:border-purple-500 transition-all"
                                placeholder="1.00">
                        </div>
                        <div>
                            <label for="cantidad" class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                                Cantidad
                            </label>
                            <input type="number" id="cantidad" min="1" step="1" value="1"
                                class="w-full border-2 border-gray-300 rounded-xl p-3 text-center text-lg font-semibold focus:ring-4 focus:ring-purple-200 focus:border-purple-500 transition-all"
                                placeholder="1">
                        </div>
                    </div>

                    <!-- Vista previa del área -->
                    <div class="mt-6 p-4 bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl border border-purple-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                </svg>
                                <span class="font-semibold text-gray-700">Área Total:</span>
                            </div>
                            <span id="preview-area" class="text-2xl font-bold text-purple-600">1.00 m²</span>
                        </div>
                    </div>
                </div>

                {{-- 3. OPCIONES ADICIONALES --}}
                <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-xl">3</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">
                            Opciones de Impresión
                        </h3>
                    </div>
                    
                    <!-- Checkbox Diseño -->
                    <label class="flex items-start gap-4 p-4 bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl border-2 border-purple-200 cursor-pointer hover:border-purple-400 hover:shadow-md transition-all group mb-4">
                        <input type="checkbox" id="solicitar_diseno" 
                                class="mt-1 w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500 transition">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                </svg>
                                <span class="font-bold text-gray-800 group-hover:text-purple-600 transition-colors">
                                    Solicitar Diseño Gráfico Profesional
                                </span>
                            </div>
                            <p class="text-sm text-purple-600 font-semibold">+ $10.000 CLP (Costo fijo)</p>
                            <p class="text-xs text-gray-600 mt-1">Nuestro equipo creará el diseño por ti</p>
                        </div>
                    </label>

                    <!-- Upload de Archivo -->
                    <div class="p-4 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border-2 border-blue-200">
                        <label for="subir_archivo" class="block text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Subir tu Archivo de Diseño
                            <span class="text-xs text-gray-500">(Opcional si solicitaste diseño)</span>
                        </label>
                        <input type="file" name="archivo_diseno" id="subir_archivo"
                                class="w-full p-3 border-2 border-dashed border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all hover:border-blue-400 cursor-pointer bg-white
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100"/>
                        <p class="text-xs text-gray-500 mt-2">Formatos: PDF, PNG, JPG, AI • Tamaño máximo: 10MB</p>
                    </div>

                    <!-- Nota informativa -->
                    <div class="mt-4 p-4 bg-yellow-50 rounded-xl border border-yellow-200">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <p class="text-sm text-gray-700">
                                <span class="font-bold">Importante:</span> Debes solicitar diseño gráfico O subir tu propio archivo para continuar.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- SECCIÓN DERECHA: Resumen --}}
            <div class="lg:col-span-1">
                <div id="resumen-cotizacion" class="sticky top-8 rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
                    
                    <!-- Header del Resumen -->
                    <div class="bg-gradient-to-br from-purple-600 to-pink-600 p-6 text-white">
                        <h2 class="text-2xl font-bold flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Resumen del Pedido
                        </h2>
                    </div>

                    <div class="p-6 bg-white space-y-4">
                        <!-- Detalles del Trabajo -->
                        <div class="space-y-3">
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 font-semibold">Tipo de Trabajo</p>
                                    <p id="resumen-producto" class="font-bold text-gray-800">---</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="p-3 bg-gray-50 rounded-xl">
                                    <p class="text-xs text-gray-500 font-semibold">Área Total</p>
                                    <p id="resumen-area" class="text-lg font-bold text-purple-600">0.00 m²</p>
                                </div>
                                <div class="p-3 bg-gray-50 rounded-xl">
                                    <p class="text-xs text-gray-500 font-semibold">Unidades</p>
                                    <p id="resumen-cantidad" class="text-lg font-bold text-purple-600">0</p>
                                </div>
                            </div>

                            <div class="p-3 bg-purple-50 rounded-xl border border-purple-200">
                                <p class="text-xs text-gray-500 font-semibold mb-1">Valor Base (por m²)</p>
                                <p id="resumen-valor-base" class="text-xl font-bold text-purple-600">$0.00</p>
                            </div>
                        </div>
                        
                        <!-- Detalle de Costos -->
                        <div class="border-t-2 border-gray-100 pt-4 space-y-3">
                            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                Detalle de Costos
                            </h3>
                            
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Costo por Área y Unidades:</span>
                                <span id="costo-base" class="font-bold text-gray-800">$0.00</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Diseño Gráfico:</span>
                                <span id="costo-diseno" class="font-bold text-gray-800">$0.00</span>
                            </div>
                        </div>

                        <!-- Total Final -->
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border-2 border-green-200">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-800">TOTAL ESTIMADO</span>
                                <span id="total-final" class="text-3xl font-extrabold text-green-700">$0.00</span>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="space-y-3 pt-4">
                            <form action="{{ route('carrito.store') }}" method="POST" id="form-carrito" enctype="multipart/form-data">
                                @csrf
                                
                                <input type="hidden" name="cotizacion_id" id="input_cotizacion_id"> 
                                <input type="hidden" name="producto_id" value=""> 
                                <input type="hidden" name="alto" id="input_alto">
                                <input type="hidden" name="ancho" id="input_ancho">
                                <input type="hidden" name="cantidad" id="input_cantidad">
                                <input type="hidden" name="costo_final" id="input_costo_final">
                                <input type="hidden" name="requiere_diseno" id="input_requiere_diseno">

                                <button type="submit" id="btn-carrito" disabled
                                    class="group relative block w-full overflow-hidden rounded-xl bg-gradient-to-br from-green-600 via-green-500 to-emerald-600 p-0.5 shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                                    <div class="relative bg-gradient-to-br from-green-600 to-emerald-600 rounded-xl overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <div class="relative px-6 py-4 flex items-center justify-center gap-3">
                                            <svg class="w-6 h-6 text-white group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            <span class="text-lg font-bold text-white">
                                                Añadir al Carrito
                                            </span>
                                        </div>
                                    </div>
                                </button>
                            </form>

                            <a href="{{ route('catalogo.index') }}" class="block w-full text-center px-6 py-3 border-2 border-purple-600 text-purple-600 font-bold rounded-xl hover:bg-purple-50 transition-all duration-300 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                Ver Catálogo
                            </a>
                        </div>

                        <!-- Info adicional -->
                        <div class="mt-4 p-4 bg-blue-50 rounded-xl border border-blue-200">
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-xs text-gray-700 leading-relaxed">
                                    Esta es una cotización estimada. El precio final puede variar según las especificaciones finales del proyecto.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const COSTO_DISENO_BASE = 10000;
        
        // Elementos de Entrada
        const selectTrabajo = document.getElementById('tipo_trabajo');
        const inputAlto = document.getElementById('alto');
        const inputAncho = document.getElementById('ancho');
        const inputCantidad = document.getElementById('cantidad');
        const checkDiseno = document.getElementById('solicitar_diseno');
        const inputArchivo = document.getElementById('subir_archivo');
        const btnCarrito = document.getElementById('btn-carrito');
        const previewArea = document.getElementById('preview-area');

        // Elementos de Salida (Resumen)
        const resumenProducto = document.getElementById('resumen-producto');
        const resumenArea = document.getElementById('resumen-area');
        const resumenCantidad = document.getElementById('resumen-cantidad');
        const resumenValorBase = document.getElementById('resumen-valor-base');
        const costoBaseEl = document.getElementById('costo-base');
        const costoDisenoEl = document.getElementById('costo-diseno');
        const totalFinalEl = document.getElementById('total-final');

        // Inputs Ocultos
        const inputCotizacionId = document.getElementById('input_cotizacion_id');
        const inputAltoHidden = document.getElementById('input_alto');
        const inputAnchoHidden = document.getElementById('input_ancho');
        const inputCantidadHidden = document.getElementById('input_cantidad');
        const inputCostoFinalHidden = document.getElementById('input_costo_final');
        const inputRequiereDisenoHidden = document.getElementById('input_requiere_diseno');

        // Función de Cálculo Principal
        function calcularCotizacion() {
            const selectedOption = selectTrabajo.options[selectTrabajo.selectedIndex];
            const valorBase = parseFloat(selectedOption.getAttribute('data-valor')) || 0;
            const nombreProducto = selectedOption.getAttribute('data-nombre') || '---';
            const cotizacionId = selectedOption.value || null;

            const alto = parseFloat(inputAlto.value) || 0;
            const ancho = parseFloat(inputAncho.value) || 0;
            const cantidad = parseInt(inputCantidad.value) || 0;
            const requiereDiseno = checkDiseno.checked;
            const archivoSubido = inputArchivo.files.length > 0;

            // Bloquear inputs si no se ha seleccionado un trabajo
            const isTrabajoSelected = valorBase > 0;
            inputAlto.disabled = inputAncho.disabled = inputCantidad.disabled = checkDiseno.disabled = !isTrabajoSelected;
            
            if (!isTrabajoSelected) {
                updateResumen(0, 0, 0, 0, '---', 0, 0, 0, 0, false, false);
                return;
            }

            // Cálculos
            const area = (alto * ancho);
            let costoBase = area * valorBase * cantidad;
            const costoDiseno = requiereDiseno ? COSTO_DISENO_BASE : 0;
            const totalFinal = costoBase + costoDiseno;
            
            // Actualizar preview del área
            previewArea.textContent = `${area.toFixed(2)} m²`;
            
            updateResumen(cotizacionId, alto, ancho, cantidad, nombreProducto, valorBase, costoBase, costoDiseno, totalFinal, requiereDiseno, archivoSubido);
        }
        
        // Función para actualizar la interfaz
        // Función para actualizar la interfaz
        function updateResumen(cotizacionId, alto, ancho, cantidad, nombreProducto, valorBase, costoBase, costoDiseno, totalFinal, requiereDiseno, archivoSubido) {
            
            const area = (alto * ancho).toFixed(2);

            // Actualizar Resumen
            resumenProducto.textContent = nombreProducto;
            resumenArea.textContent = `${area} m²`;
            resumenCantidad.textContent = cantidad.toString();
            resumenValorBase.textContent = `$${valorBase.toLocaleString('es-CL')}`; 
            costoBaseEl.textContent = `$${Math.round(costoBase).toLocaleString('es-CL')}`;
            costoDisenoEl.textContent = `$${costoDiseno.toLocaleString('es-CL')}`;
            totalFinalEl.textContent = `$${Math.round(totalFinal).toLocaleString('es-CL')}`;
            
            // Lógica de habilitación del botón
            const isReadyForCalculation = cotizacionId && totalFinal > 0 && alto > 0 && ancho > 0 && cantidad > 0;
            const isArtRequirementMet = requiereDiseno || archivoSubido;
            const isReady = isReadyForCalculation && isArtRequirementMet;
            
            btnCarrito.disabled = !isReady;

            // Actualizar Inputs Ocultos
            inputCotizacionId.value = cotizacionId || '';
            inputAltoHidden.value = alto.toString();
            inputAnchoHidden.value = ancho.toString();
            inputCantidadHidden.value = cantidad.toString();
            inputCostoFinalHidden.value = Math.round(totalFinal).toString();
            inputRequiereDisenoHidden.value = requiereDiseno ? '1' : '0'; 
        }

        // Event Listeners
        inputArchivo.addEventListener('change', calcularCotizacion);
        selectTrabajo.addEventListener('change', calcularCotizacion);
        inputAlto.addEventListener('input', calcularCotizacion);
        inputAncho.addEventListener('input', calcularCotizacion);
        inputCantidad.addEventListener('input', calcularCotizacion);
        checkDiseno.addEventListener('change', calcularCotizacion);

        // Inicializar
        window.onload = calcularCotizacion;
    </script>
</body>
</html>