@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50 py-8">
    <div class="max-w-2xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800">Editar Usuario</h1>
            <a href="{{ route('administracion.usuarios.index') }}" class="text-indigo-600 hover:underline">← Volver</a>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <p class="font-bold">Errores encontrados:</p>
                <ul class="list-disc ml-5 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-md p-8">
            <form action="{{ route('administracion.usuarios.update', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo *</label>
                        <input type="text" name="name" value="{{ old('name', $usuario->name) }}" required
                               class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $usuario->email) }}" required
                               class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono *</label>
                        <input type="text" name="telefono" value="{{ old('telefono', $usuario->telefono) }}" required
                               class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Región</label>
                            <select id="region" name="region" class="w-full border rounded-lg px-4 py-2" onchange="cargarCiudades()">
                                <option value="">Seleccione una región</option>
                                @foreach(config('ubicaciones.regiones') as $nombreRegion => $ciudades)
                                    <option value="{{ $nombreRegion }}">{{ $nombreRegion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ciudad</label>
                            <select id="ciudad" name="ciudad" class="w-full border rounded-lg px-4 py-2" onchange="cargarComunas()">
                                <option value="">Seleccione una ciudad</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Comuna</label>
                            <select id="comuna" name="comuna" class="w-full border rounded-lg px-4 py-2">
                                <option value="">Seleccione una comuna</option>
                            </select>
                        </div>
                    </div>

                    <div class="bg-yellow-50 border-2 border-yellow-300 rounded-lg p-4">
                        <label class="block text-sm font-bold text-gray-800 mb-2">
                            <svg class="w-5 h-5 inline text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            Rol del Usuario *
                        </label>
                        <select name="rol" required class="w-full border-2 border-yellow-400 rounded-lg px-4 py-3 text-lg font-semibold focus:ring-4 focus:ring-yellow-300 focus:border-yellow-500 transition-all">
                            <option value="cliente" {{ $usuario->rol == 'cliente' ? 'selected' : '' }}>👤 Cliente</option>
                            <option value="admin" {{ $usuario->rol == 'admin' ? 'selected' : '' }}>⚙️ Administrador</option>
                        </select>
                        <p class="text-xs text-gray-600 mt-2">
                            <strong>Rol actual:</strong> 
                            <span class="px-2 py-1 rounded {{ $usuario->rol == 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $usuario->rol == 'admin' ? '⚙️ Administrador' : '👤 Cliente' }}
                            </span>
                        </p>
                    </div>

                    <hr class="my-6">
                    <p class="text-sm text-gray-600 mb-4">Cambiar contraseña (dejar en blanco para mantener la actual)</p>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nueva Contraseña</label>
                        <input type="password" name="password" class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" class="w-full border rounded-lg px-4 py-2">
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700">
                        Guardar Cambios
                    </button>
                    <a href="{{ route('administracion.usuarios.index') }}" class="px-6 py-3 bg-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-400">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const ubicaciones = @json(config('ubicaciones.regiones'));
    const ciudadActual = "{{ old('ciudad', $usuario->ciudad) }}";
    const comunaActual = "{{ old('comuna', $usuario->comuna) }}";
    
    function detectarRegion() {
        if (!ciudadActual) return null;
        
        for (const [region, ciudades] of Object.entries(ubicaciones)) {
            if (ciudades[ciudadActual]) {
                return region;
            }
        }
        return null;
    }
    
    function cargarCiudades() {
        const regionSelect = document.getElementById('region');
        const ciudadSelect = document.getElementById('ciudad');
        const comunaSelect = document.getElementById('comuna');
        
        ciudadSelect.innerHTML = '<option value="">Seleccione una ciudad</option>';
        comunaSelect.innerHTML = '<option value="">Seleccione una comuna</option>';
        
        const regionSeleccionada = regionSelect.value;
        if (regionSeleccionada && ubicaciones[regionSeleccionada]) {
            const ciudades = Object.keys(ubicaciones[regionSeleccionada]);
            ciudades.forEach(ciudad => {
                const option = document.createElement('option');
                option.value = ciudad;
                option.textContent = ciudad;
                if (ciudad === ciudadActual) {
                    option.selected = true;
                }
                ciudadSelect.appendChild(option);
            });
            
            // Si se cargó la ciudad actual, cargar comunas
            if (ciudadActual && ciudades.includes(ciudadActual)) {
                cargarComunas();
            }
        }
    }
    
    function cargarComunas() {
        const regionSelect = document.getElementById('region');
        const ciudadSelect = document.getElementById('ciudad');
        const comunaSelect = document.getElementById('comuna');
        
        comunaSelect.innerHTML = '<option value="">Seleccione una comuna</option>';
        
        const regionSeleccionada = regionSelect.value;
        const ciudadSeleccionada = ciudadSelect.value;
        
        if (regionSeleccionada && ciudadSeleccionada && ubicaciones[regionSeleccionada][ciudadSeleccionada]) {
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
    
    // Inicializar dropdowns con valores actuales del usuario
    document.addEventListener('DOMContentLoaded', function() {
        if (ciudadActual) {
            const regionDetectada = detectarRegion();
            if (regionDetectada) {
                document.getElementById('region').value = regionDetectada;
                cargarCiudades();
            }
        }
    });
</script>
@endpush

@endsection
