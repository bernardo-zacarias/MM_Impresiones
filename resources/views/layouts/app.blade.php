<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MM Impresiones')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> 
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f9; }
        @yield('styles')
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <main class="flex-grow p-8 max-w-7xl mx-auto w-full">
        @yield('content')
    </main>

    <script src="{{ asset('js/app.js') }}"></script>
    
    @yield('scripts')
</body>
</html>