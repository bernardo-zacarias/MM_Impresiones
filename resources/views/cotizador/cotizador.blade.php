<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizador de Trabajos - Iluminar</title>
    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f7f7f7; }
        /* Estilo para enfocar la selección */
        .select-focus:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.4);
            border-color: #4f46e5;
        }
    </style>
</head>
<body class="p-4 sm:p-8">

    <div class="max-w-4xl mx-auto bg-white p-6 sm:p-10 rounded-3xl shadow-2xl border border-gray-100">

        <h1 class="text-4xl font-extrabold text-indigo-700 mb-2 border-b pb-2">
            Calculadora de Cotización <span class="text-sm text-gray-500 block sm:inline">| Iluminar</span>
        </h1>
        <p class="text-gray-500 mb-8">Selecciona tu tipo de trabajo y las dimensiones para obtener un presupuesto en tiempo real.</p>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6 shadow-md" role="alert">
                <strong class="font-bold">¡Genial!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- SECCIÓN IZQUIERDA: Formulario de Entradas --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- 1. SELECCIÓN DE TRABAJO (PRODUCTO/COTIZACIÓN) --}}
                <div class="p-6 bg-indigo-50 rounded-xl border border-indigo-200">
                    <label for="tipo_trabajo" class="block text-lg font-bold text-indigo-700 mb-3">
                        1. Tipo de Trabajo
                    </label>
                    <select id="tipo_trabajo" 
                            class="w-full border-gray-300 rounded-lg shadow-md p-3 text-lg focus:ring-indigo-500 focus:border-indigo-500 transition select-focus">
                        <option value="" data-valor="0">Selecciona un tipo de trabajo...</option>
                        {{-- Iteramos los datos pasados desde el controlador --}}
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
                <div class="p-6 bg-white rounded-xl shadow-lg space-y-4">
                    <label class="block text-lg font-bold text-gray-800 mb-3">
                        2. Dimensiones y Cantidad (en metros)
                    </label>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="alto" class="block text-sm font-medium text-gray-600 mb-1">Alto (m)</label>
                            <input type="number" id="alto" min="0.01" step="0.01" value="1.00"
                                class="w-full border-gray-300 rounded-lg p-3 text-center focus:ring-blue-500 focus:border-blue-500 transition select-focus"
                                placeholder="1.00">
                        </div>
                        <div>
                            <label for="ancho" class="block text-sm font-medium text-gray-600 mb-1">Ancho (m)</label>
                            <input type="number" id="ancho" min="0.01" step="0.01" value="1.00"
                                class="w-full border-gray-300 rounded-lg p-3 text-center focus:ring-blue-500 focus:border-blue-500 transition select-focus"
                                placeholder="1.00">
                        </div>
                        <div>
                            <label for="cantidad" class="block text-sm font-medium text-gray-600 mb-1">Cantidad (Unidades)</label>
                            <input type="number" id="cantidad" min="1" step="1" value="1"
                                class="w-full border-gray-300 rounded-lg p-3 text-center focus:ring-blue-500 focus:border-blue-500 transition select-focus"
                                placeholder="1">
                        </div>
                    </div>
                </div>

                {{-- 3. OPCIONES ADICIONALES --}}
                <div class="p-6 bg-white rounded-xl shadow-lg space-y-4">
                    <label class="block text-lg font-bold text-gray-800 mb-3">
                        3. Opciones de Impresión
                    </label>
                    <div class="flex items-center space-x-4">
                        <input type="checkbox" id="solicitar_diseno" 
                                class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 transition">
                        <label for="solicitar_diseno" class="text-base font-medium text-gray-700 cursor-pointer">
                            Solicitar Diseño Gráfico (Costo fijo: ${{ number_format(10000, 2) }})
                        </label>
                    </div>

                    <div class="mt-4">
                        <label for="subir_archivo" class="block text-sm font-medium text-gray-600 mb-1">
                            Opcional: Subir Archivo de Diseño (No se envía, solo referencia)
                        </label>
                        <input type="file" id="subir_archivo"
                                class="w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-violet-50 file:text-indigo-700
                                hover:file:bg-violet-100 transition
                              "/>
                    </div>
                </div>

            </div>

            {{-- SECCIÓN DERECHA: Resumen del Pedido (DETALLES Y TOTAL) --}}
            <div class="lg:col-span-1">
                <div id="resumen-cotizacion" class="sticky top-10 p-6 bg-indigo-600 text-white rounded-xl shadow-2xl space-y-4">
                    
                    <h2 class="text-2xl font-bold border-b border-indigo-400 pb-2 mb-4">
                        Resumen del Pedido
                    </h2>

                    {{-- Detalles Dinámicos --}}
                    <div>
                        <p class="font-semibold text-lg" id="resumen-producto">
                            Trabajo: <span class="font-normal text-indigo-200">---</span>
                        </p>
                        <p class="text-sm">Área Total: <span id="resumen-area">0.00 m²</span></p>
                        <p class="text-sm">Unidades: <span id="resumen-cantidad">0</span></p>
                        <p class="text-sm">Valor Base (por m²): <span id="resumen-valor-base">$0.00</span></p>
                    </div>
                    
                    <div class="border-t border-dashed border-indigo-400 pt-4 space-y-2">
                        <h3 class="text-xl font-bold">Detalle de Costos</h3>
                        <div class="flex justify-between text-sm">
                            <span>Costo por Área y Unidades:</span>
                            <span id="costo-base">$0.00</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span>Costo Diseño (CLP 10.000):</span>
                            <span id="costo-diseno">$0.00</span>
                        </div>
                    </div>

                    {{-- Total Final --}}
                    <div class="border-t border-white pt-4 mt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-extrabold">TOTAL ESTIMADO:</span>
                            <span class="text-3xl font-extrabold text-yellow-300" id="total-final">$0.00</span>
                        </div>
                    </div>

                    {{-- Botones de Acción --}}
                    <div class="mt-6 space-y-3">
                        {{-- El formulario POST simula el envío al carrito --}}
                        <form action="{{ url('/carrito') }}" method="POST" id="form-carrito">
                            @csrf
                            {{-- Campos ocultos para enviar los datos de la cotización final al backend --}}
                            <input type="hidden" name="cotizacion_id" id="input_cotizacion_id">
                            <input type="hidden" name="alto" id="input_alto">
                            <input type="hidden" name="ancho" id="input_ancho">
                            <input type="hidden" name="cantidad" id="input_cantidad">
                            <input type="hidden" name="costo_final" id="input_costo_final">
                            <input type="hidden" name="requiere_diseno" id="input_requiere_diseno">
                            
                            <button type="submit" id="btn-carrito" disabled
                                class="w-full bg-yellow-400 text-indigo-900 font-bold py-3 rounded-xl shadow-lg transition duration-300 
                                hover:bg-yellow-500 disabled:bg-gray-400 disabled:text-gray-700 disabled:cursor-not-allowed">
                                Añadir al Carrito de Compras
                            </button>
                        </form>

                        <a href="{{ url('/catalogo') }}" class="w-full block text-center border border-white text-white font-semibold py-3 rounded-xl transition duration-300 hover:bg-indigo-700">
                            Ver Catálogo
                        </a>
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
        const btnCarrito = document.getElementById('btn-carrito');

        // Elementos de Salida (Resumen)
        const resumenProducto = document.getElementById('resumen-producto').querySelector('span');
        const resumenArea = document.getElementById('resumen-area');
        const resumenCantidad = document.getElementById('resumen-cantidad');
        const resumenValorBase = document.getElementById('resumen-valor-base');
        const costoBaseEl = document.getElementById('costo-base');
        const costoDisenoEl = document.getElementById('costo-diseno');
        const totalFinalEl = document.getElementById('total-final');

        // Inputs Ocultos para el Formulario del Carrito
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

            // Bloquear inputs si no se ha seleccionado un trabajo
            const isTrabajoSelected = valorBase > 0;
            inputAlto.disabled = inputAncho.disabled = inputCantidad.disabled = checkDiseno.disabled = !isTrabajoSelected;
            if (!isTrabajoSelected) {
                 // Asegurarse de que si no hay trabajo, los valores de dimensión se reinicien en el cálculo
                 inputAlto.value = inputAncho.value = '1.00';
                 inputCantidad.value = '1';
                 checkDiseno.checked = false;
                 updateResumen(0, 0, 0, 0, '---', '0.00', '0', '0.00', false);
                 return;
            }

            // 1. Cálculo del Área (m²)
            const area = (alto * ancho).toFixed(2);
            
            // 2. Cálculo del Costo Base por Área y Cantidad
            let costoBase = parseFloat(area) * valorBase * cantidad;
            
            // 3. Costo de Diseño
            const costoDiseno = requiereDiseno ? COSTO_DISENO_BASE : 0;
            
            // 4. Total Final
            const totalFinal = costoBase + costoDiseno;
            
            // Actualizar el Resumen y los Inputs Ocultos
            updateResumen(cotizacionId, alto, ancho, cantidad, nombreProducto, valorBase, costoBase, costoDiseno, totalFinal, requiereDiseno);
        }
        
        // Función para actualizar la interfaz y los inputs ocultos
        function updateResumen(cotizacionId, alto, ancho, cantidad, nombreProducto, valorBase, costoBase, costoDiseno, totalFinal, requiereDiseno) {
            
            const area = (alto * ancho).toFixed(2);

            // Actualizar Resumen
            resumenProducto.textContent = nombreProducto;
            resumenArea.textContent = `${area} m²`;
            resumenCantidad.textContent = cantidad.toString();
            resumenValorBase.textContent = `$${valorBase.toLocaleString('es-CL')}`; // Formato de moneda chilena
            costoBaseEl.textContent = `$${Math.round(costoBase).toLocaleString('es-CL')}`;
            costoDisenoEl.textContent = `$${costoDiseno.toLocaleString('es-CL')}`;
            totalFinalEl.textContent = `$${Math.round(totalFinal).toLocaleString('es-CL')}`;
            
            // Habilitar/Deshabilitar botón de carrito
            const isReady = cotizacionId && totalFinal > 0 && alto > 0 && ancho > 0 && cantidad > 0;
            btnCarrito.disabled = !isReady;

            // Actualizar Inputs Ocultos (Para enviar al carrito)
            inputCotizacionId.value = cotizacionId || '';
            inputAltoHidden.value = alto.toString();
            inputAnchoHidden.value = ancho.toString();
            inputCantidadHidden.value = cantidad.toString();
            inputCostoFinalHidden.value = Math.round(totalFinal).toString();
            inputRequiereDisenoHidden.value = requiereDiseno ? '1' : '0';
        }

        // --- Event Listeners ---
        selectTrabajo.addEventListener('change', calcularCotizacion);
        inputAlto.addEventListener('input', calcularCotizacion);
        inputAncho.addEventListener('input', calcularCotizacion);
        inputCantidad.addEventListener('input', calcularCotizacion);
        checkDiseno.addEventListener('change', calcularCotizacion);

        // Inicializar el cálculo al cargar la página
        window.onload = calcularCotizacion;
    </script>
</body>
</html>
