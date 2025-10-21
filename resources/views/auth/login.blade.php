<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-10 rounded-xl shadow-2xl w-full max-w-md">
        <h1 class="text-3xl font-extrabold text-indigo-600 text-center mb-6">Iniciar Sesión</h1>
        <p class="text-center text-sm text-gray-500 mb-8">Accede para gestionar tu cuenta o la administración.</p>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4">
                <ul class="list-disc ml-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                <input id="password" type="password" name="password" required
                       class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition duration-300">
                Acceder
            </button>
        </form>
        
        <p class="text-center text-sm text-gray-500 mt-6">
            ¿No tienes cuenta? 
            <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Regístrate aquí</a>
        </p>

    </div>
</body>
</html>
