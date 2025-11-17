<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirigiendo a Transbank...</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-50 to-purple-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-2xl p-8 text-center">
            <!-- Logo/Icono -->
            <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6 animate-pulse">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <!-- Mensaje -->
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Redirigiendo a Transbank...</h1>
            <p class="text-gray-600 mb-8">Serás redirigido automáticamente al sistema de pago seguro de Webpay Plus.</p>

            <!-- Formulario oculto -->
            <form id="transbank-form" action="{{ $url }}" method="POST">
                @csrf
                <input type="hidden" name="token_ws" value="{{ $token }}">
            </form>

            <!-- Botón manual por si falla el auto-redirect -->
            <button 
                onclick="document.getElementById('transbank-form').submit()" 
                class="px-6 py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition-all shadow-lg">
                Ir a Transbank
            </button>

            <p class="text-xs text-gray-500 mt-4">Si no eres redirigido automáticamente, haz clic en el botón.</p>
        </div>
    </div>

    <script>
        // Auto-submit después de 2 segundos
        setTimeout(function() {
            document.getElementById('transbank-form').submit();
        }, 2000);
    </script>
</body>
</html>
