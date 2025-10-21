<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cliente</title>
    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #e5e7eb; }
        .input-style { @apply w-full p-3 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition duration-150; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-2xl">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Crear Cuenta (Cliente)</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-4 text-sm">
                <p>Por favor, corrija los errores.</p>
                <ul class="list-disc ml-5 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/register') }}" method="POST">
            @csrf

            <!-- Nombre -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                <input type="text" name="name" id="name" class="input-style" value="{{ old('name') }}" required autofocus>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                <input type="email" name="email" id="email" class="input-style" value="{{ old('email') }}" required>
            </div>

            <!-- Contraseña -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                <input type="password" name="password" id="password" class="input-style" required>
            </div>

            <!-- Confirmar Contraseña -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="input-style" required>
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition duration-300 transform hover:scale-[1.01]">
                Registrarse
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            <!-- Asumiendo que su ruta de login es /login -->
            ¿Ya tienes cuenta? 
            <a href="{{ url('/login') }}" class="font-semibold text-indigo-600 hover:text-indigo-800">Inicia Sesión</a>
        </p>
    </div>
</body>
</html>
