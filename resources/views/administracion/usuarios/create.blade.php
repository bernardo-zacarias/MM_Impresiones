@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50 py-8">
    <div class="max-w-2xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800">Crear Nuevo Usuario</h1>
            <a href="{{ route('administracion.usuarios.index') }}" class="text-indigo-600 hover:underline">← Volver</a>
        </div>

        <div class="bg-white rounded-xl shadow-md p-8">
            <form action="{{ route('administracion.usuarios.store') }}" method="POST">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full border rounded-lg px-4 py-2 @error('name') border-red-500 @enderror">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full border rounded-lg px-4 py-2 @error('email') border-red-500 @enderror">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono *</label>
                        <input type="text" name="telefono" value="{{ old('telefono') }}" required
                               class="w-full border rounded-lg px-4 py-2 @error('telefono') border-red-500 @enderror">
                        @error('telefono')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
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

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rol *</label>
                        <select name="rol" required class="w-full border rounded-lg px-4 py-2">
                            <option value="cliente" {{ old('rol') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                            <option value="admin" {{ old('rol') == 'admin' ? 'selected' : '' }}>Administrador</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Contraseña *</label>
                        <input type="password" name="password" required
                               class="w-full border rounded-lg px-4 py-2 @error('password') border-red-500 @enderror">
                        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña *</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full border rounded-lg px-4 py-2">
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit" class="px-6 py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700">
                        Crear Usuario
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
                ciudadSelect.appendChild(option);
            });
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
                comunaSelect.appendChild(option);
            });
        }
    }
    
    // Restaurar valores old() después de error de validación
    document.addEventListener('DOMContentLoaded', function() {
        const oldCiudad = "{{ old('ciudad') }}";
        const oldComuna = "{{ old('comuna') }}";
        
        if (oldCiudad || oldComuna) {
            // Buscar y seleccionar la región correcta
            for (const [region, ciudades] of Object.entries(ubicaciones)) {
                if (oldCiudad && ciudades[oldCiudad]) {
                    document.getElementById('region').value = region;
                    cargarCiudades();
                    
                    setTimeout(() => {
                        document.getElementById('ciudad').value = oldCiudad;
                        cargarComunas();
                        
                        setTimeout(() => {
                            if (oldComuna) {
                                document.getElementById('comuna').value = oldComuna;
                            }
                        }, 50);
                    }, 50);
                    break;
                }
            }
        }
    });
</script>
@endpush

@endsection
