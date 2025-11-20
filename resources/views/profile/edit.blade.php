@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-semibold mb-4 group transition-all">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver a Inicio
            </a>
            <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Editar Perfil</h1>
            <p class="text-gray-600">Actualiza tu información personal</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-xl mb-8 shadow-lg">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="font-bold text-red-800 mb-2">Por favor, corrige los siguientes errores:</p>
                        <ul class="list-disc ml-5 text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('perfil.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Información Personal -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Información Personal</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nombre Completo *
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $user->name) }}" 
                               class="w-full border-2 @error('name') border-red-500 @else border-gray-300 @enderror rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" 
                               required>
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Correo Electrónico *
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}" 
                               class="w-full border-2 @error('email') border-red-500 @else border-gray-300 @enderror rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" 
                               required>
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="telefono" class="block text-sm font-semibold text-gray-700 mb-2">
                            Teléfono *
                        </label>
                        <input type="text" 
                               id="telefono" 
                               name="telefono" 
                               value="{{ old('telefono', $user->telefono) }}" 
                               class="w-full border-2 @error('telefono') border-red-500 @else border-gray-300 @enderror rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" 
                               placeholder="+56 9 1234 5678"
                               required>
                        @error('telefono')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="region" class="block text-sm font-semibold text-gray-700 mb-2">
                            Región
                        </label>
                        <select id="region" 
                                name="region" 
                                class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                                onchange="cargarCiudades()">
                            <option value="">Seleccione una región</option>
                            @foreach(config('ubicaciones.regiones') as $nombreRegion => $ciudades)
                                <option value="{{ $nombreRegion }}">{{ $nombreRegion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="ciudad" class="block text-sm font-semibold text-gray-700 mb-2">
                            Ciudad
                        </label>
                        <select id="ciudad" 
                                name="ciudad" 
                                class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                                onchange="cargarComunas()">
                            <option value="">Primero seleccione una región</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="comuna" class="block text-sm font-semibold text-gray-700 mb-2">
                            Comuna
                        </label>
                        <select id="comuna" 
                                name="comuna" 
                                class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                            <option value="">Primero seleccione una ciudad</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Cambiar Contraseña -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Cambiar Contraseña</h2>
                        <p class="text-sm text-gray-600">Deja estos campos vacíos si no deseas cambiar tu contraseña</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nueva Contraseña
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="w-full border-2 @error('password') border-red-500 @else border-gray-300 @enderror rounded-xl px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                               placeholder="Mínimo 8 caracteres">
                        @error('password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Confirmar Nueva Contraseña
                        </label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                               placeholder="Repite la contraseña">
                    </div>
                </div>

                <div class="mt-4 p-4 bg-purple-50 border border-purple-200 rounded-lg">
                    <p class="text-sm text-purple-800">
                        <strong>Consejo de seguridad:</strong> Usa al menos 8 caracteres con una combinación de letras, números y símbolos.
                    </p>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex items-center gap-4">
                <button type="submit" class="flex-1 px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all shadow-lg transform hover:scale-[1.02]">
                    💾 Guardar Cambios
                </button>
                <a href="{{ route('home') }}" class="flex-1 px-8 py-4 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition-all text-center">
                    ❌ Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Datos de ubicaciones desde Laravel
    const ubicaciones = @json(config('ubicaciones.regiones'));
    const ciudadActual = '{{ old('ciudad', $user->ciudad) }}';
    const comunaActual = '{{ old('comuna', $user->comuna) }}';

    function cargarCiudades() {
        const regionSelect = document.getElementById('region');
        const ciudadSelect = document.getElementById('ciudad');
        const comunaSelect = document.getElementById('comuna');
        
        const regionSeleccionada = regionSelect.value;
        
        // Limpiar selectores
        ciudadSelect.innerHTML = '<option value="">Seleccione una ciudad</option>';
        comunaSelect.innerHTML = '<option value="">Primero seleccione una ciudad</option>';
        
        if (regionSeleccionada && ubicaciones[regionSeleccionada]) {
            const ciudades = ubicaciones[regionSeleccionada];
            
            for (const ciudad in ciudades) {
                const option = document.createElement('option');
                option.value = ciudad;
                option.textContent = ciudad;
                if (ciudad === ciudadActual) {
                    option.selected = true;
                }
                ciudadSelect.appendChild(option);
            }
            
            // Si hay ciudad seleccionada, cargar comunas
            if (ciudadActual) {
                cargarComunas();
            }
        }
    }

    function cargarComunas() {
        const regionSelect = document.getElementById('region');
        const ciudadSelect = document.getElementById('ciudad');
        const comunaSelect = document.getElementById('comuna');
        
        const regionSeleccionada = regionSelect.value;
        const ciudadSeleccionada = ciudadSelect.value;
        
        // Limpiar selector de comunas
        comunaSelect.innerHTML = '<option value="">Seleccione una comuna</option>';
        
        if (regionSeleccionada && ciudadSeleccionada && 
            ubicaciones[regionSeleccionada] && 
            ubicaciones[regionSeleccionada][ciudadSeleccionada]) {
            
            const comunas = ubicaciones[regionSeleccionada][ciudadSeleccionada];
            
            comunas.forEach(comuna => {
                const option = document.createElement('option');
                option.value = comuna;
                option.textContent = comuna;
                if (comuna === comunaActual) {
                    option.selected = true;
                }
                comunaSelect.appendChild(option);
            });
        }
    }

    // Detectar región basándose en ciudad actual
    function detectarRegion() {
        if (!ciudadActual) return null;
        
        for (const [region, ciudades] of Object.entries(ubicaciones)) {
            if (ciudades[ciudadActual]) {
                return region;
            }
        }
        return null;
    }

    // Inicializar al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        const regionDetectada = detectarRegion();
        
        if (regionDetectada) {
            document.getElementById('region').value = regionDetectada;
            cargarCiudades();
        }
    });
</script>
@endpush
