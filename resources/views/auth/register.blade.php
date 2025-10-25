<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cliente - MM Impresiones</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 to-indigo-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-2xl">
        <!-- Card Principal -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
            
            <!-- Header con Gradiente -->
            <div class="bg-gradient-to-br from-indigo-600 to-purple-600 p-8 text-center">
                <div class="inline-block p-4 bg-white/20 rounded-2xl backdrop-blur-sm mb-4">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h2 class="text-4xl font-extrabold text-white mb-2">Crear Cuenta</h2>
                <p class="text-indigo-100">Únete a MM Impresiones</p>
            </div>

            <!-- Contenido del Formulario -->
            <div class="p-8">
                
                <!-- Mensajes de Error -->
                @if ($errors->any())
                    <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 p-6 rounded-xl mb-6 shadow-lg">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="font-bold text-red-800 mb-2">Por favor, corrija los siguientes errores:</p>
                                <p class="text-sm text-red-700 mb-2">La contraseña requiere 8 caracteres, mayúsculas, minúsculas y números.</p>
                                <ul class="list-disc ml-5 text-red-700 text-sm space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ url('/register') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Grid de 2 columnas para campos -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        
                        <!-- Nombre Completo -->
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Nombre Completo
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   class="w-full p-4 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 transition-all" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus
                                   placeholder="Ej: Juan Pérez">
                        </div>

                        <!-- Correo Electrónico -->
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Correo Electrónico
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   class="w-full p-4 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 transition-all" 
                                   value="{{ old('email') }}" 
                                   required
                                   placeholder="correo@ejemplo.com">
                        </div>
                        
                        <!-- Teléfono -->
                        <div>
                            <label for="telefono" class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                Teléfono
                            </label>
                            <input type="text" 
                                   name="telefono" 
                                   id="telefono" 
                                   class="w-full p-4 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 transition-all" 
                                   value="{{ old('telefono') }}" 
                                   required
                                   placeholder="+56 9 1234 5678">
                        </div>

                        <!-- Ciudad -->
                        <div>
                            <label for="ciudad" class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                Ciudad
                            </label>
                            <input type="text" 
                                   name="ciudad" 
                                   id="ciudad" 
                                   class="w-full p-4 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 transition-all" 
                                   value="{{ old('ciudad') }}" 
                                   required
                                   placeholder="Ej: Santiago">
                        </div>

                        <!-- Comuna -->
                        <div>
                            <label for="comuna" class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Comuna
                            </label>
                            <input type="text" 
                                   name="comuna" 
                                   id="comuna" 
                                   class="w-full p-4 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 transition-all" 
                                   value="{{ old('comuna') }}" 
                                   required
                                   placeholder="Ej: Providencia">
                        </div>
                    </div>

                    <!-- Sección de Contraseñas -->
                    <div class="pt-4 border-t-2 border-gray-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            
                            <!-- Contraseña -->
                            <div>
                                <label for="password" class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    Contraseña
                                </label>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="w-full p-4 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 transition-all" 
                                       placeholder="Min 8 caracteres" 
                                       required>
                                <p class="text-xs text-gray-500 mt-2">Debe incluir: mayúsculas, minúsculas y números</p>
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Confirmar Contraseña
                                </label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       class="w-full p-4 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 transition-all" 
                                       placeholder="Repite tu contraseña" 
                                       required>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Seguridad -->
                    <div class="p-4 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Tus datos están seguros</p>
                                <p class="text-xs text-gray-600 mt-1">Utilizamos encriptación para proteger tu información personal</p>
                            </div>
                        </div>
                    </div>

                    <!-- Botón de Registro -->
                    <button type="submit" class="group relative block w-full overflow-hidden rounded-xl bg-gradient-to-br from-indigo-600 via-indigo-500 to-purple-600 p-0.5 shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-[1.02] mt-6">
                        <div class="relative bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative px-8 py-4 flex items-center justify-center gap-3">
                                <svg class="w-6 h-6 text-white group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                                <span class="text-xl font-bold text-white">
                                    Crear mi Cuenta
                                </span>
                                <svg class="w-6 h-6 text-white group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                        </div>
                    </button>
                </form>

                <!-- Link a Login -->
                <div class="mt-8 text-center p-4 bg-gray-50 rounded-xl">
                    <p class="text-gray-700">
                        ¿Ya tienes cuenta? 
                        <a href="{{ url('/login') }}" class="font-bold text-indigo-600 hover:text-purple-600 transition-colors inline-flex items-center gap-1 group">
                            Inicia Sesión
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">© 2025 MM Impresiones. Todos los derechos reservados.</p>
        </div>
    </div>

</body>
</html>