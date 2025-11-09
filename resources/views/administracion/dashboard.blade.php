<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración | Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
@extends('layouts.app')

<body class="bg-gradient-to-br from-gray-50 to-indigo-50 min-h-screen">

    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 h-screen w-72 bg-gradient-to-b from-gray-900 to-gray-800 text-white shadow-2xl z-50">
        <div class="p-6 border-b border-gray-700">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-12 h-12 bg-gradient-to-br from-red-600 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold">Panel Admin</h2>
                    <p class="text-xs text-gray-400">MM Impresiones</p>
                </div>
            </div>
        </div>

        <nav class="p-4 space-y-2">
            <a href="{{ route('administracion.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-red-600 to-pink-600 rounded-xl font-semibold shadow-lg transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('administracion.categorias.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-xl font-medium transition-all group">
                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                </svg>
                Categorías
            </a>

            <a href="{{ route('administracion.productos.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-xl font-medium transition-all group">
                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Productos
            </a>

            <div class="pt-4 border-t border-gray-700">
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 rounded-xl font-medium cursor-not-allowed opacity-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Pedidos
                    <span class="ml-auto text-xs bg-gray-700 px-2 py-1 rounded-full">Pronto</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 rounded-xl font-medium cursor-not-allowed opacity-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Usuarios
                    <span class="ml-auto text-xs bg-gray-700 px-2 py-1 rounded-full">Pronto</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 rounded-xl font-medium cursor-not-allowed opacity-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Reportes
                    <span class="ml-auto text-xs bg-gray-700 px-2 py-1 rounded-full">Pronto</span>
                </a>
            </div>
        </nav>

        <div class="absolute bottom-0 w-full p-4 border-t border-gray-700">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-sm truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400">Administrador</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 rounded-xl font-semibold transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </aside>

    <!-- Contenido Principal -->
    <main class="ml-72 p-8">
        <div class="max-w-7xl mx-auto">
            
            <!-- Header -->
            <div class="mb-10">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-5xl font-extrabold text-gray-800 mb-2 bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent">
                            Dashboard
                        </h1>
                        <p class="text-gray-600 text-lg">Bienvenido de nuevo, {{ Auth::user()->name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">{{ now()->format('l, d F Y') }}</p>
                        <p class="text-2xl font-bold text-gray-800">{{ now()->format('H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Alerta de Bienvenida -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-6 rounded-xl mb-8 shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-green-800">¡Bienvenido al Panel de Administración!</h3>
                        <p class="text-green-700">Tienes acceso completo al sistema con privilegios de Administrador</p>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-xl p-6 border-l-4 border-indigo-500 transform hover:scale-105 transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-4xl font-extrabold text-gray-800 mb-1">0</p>
                    <p class="text-sm text-gray-600 font-semibold">Categorías Activas</p>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-6 border-l-4 border-pink-500 transform hover:scale-105 transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-red-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-4xl font-extrabold text-gray-800 mb-1">0</p>
                    <p class="text-sm text-gray-600 font-semibold">Productos Total</p>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-6 border-l-4 border-green-500 transform hover:scale-105 transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-4xl font-extrabold text-gray-800 mb-1">0</p>
                    <p class="text-sm text-gray-600 font-semibold">Pedidos Pendientes</p>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-6 border-l-4 border-yellow-500 transform hover:scale-105 transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-4xl font-extrabold text-gray-800 mb-1">0</p>
                    <p class="text-sm text-gray-600 font-semibold">Clientes Registrados</p>
                </div>
            </div>

            <!-- Accesos Rápidos -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card Categorías -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 group hover:shadow-2xl transition-all">
                    <div class="bg-gradient-to-br from-indigo-500 to-purple-500 p-6">
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Gestión de Categorías</h3>
                        <p class="text-indigo-100">Administra los tipos de productos disponibles</p>
                    </div>
                    <div class="p-6">
                        <a href="{{ route('administracion.categorias.index') }}" class="group relative block w-full overflow-hidden rounded-xl bg-gradient-to-br from-indigo-600 to-purple-600 p-0.5 shadow-lg hover:shadow-xl transition-all">
                            <div class="relative bg-white rounded-xl">
                                <div class="relative px-6 py-3 flex items-center justify-center gap-2">
                                    <span class="font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                        Ir a Categorías
                                    </span>
                                    <svg class="w-5 h-5 text-indigo-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Card Productos -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 group hover:shadow-2xl transition-all">
                    <div class="bg-gradient-to-br from-pink-500 to-red-500 p-6">
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Gestión de Productos</h3>
                        <p class="text-pink-100">Crea, edita o elimina productos del inventario</p>
                    </div>
                    <div class="p-6">
                        <a href="{{ route('administracion.productos.index') }}" class="group relative block w-full overflow-hidden rounded-xl bg-gradient-to-br from-pink-600 to-red-600 p-0.5 shadow-lg hover:shadow-xl transition-all">
                            <div class="relative bg-white rounded-xl">
                                <div class="relative px-6 py-3 flex items-center justify-center gap-2">
                                    <span class="font-bold bg-gradient-to-r from-pink-600 to-red-600 bg-clip-text text-transparent">
                                        Ir a Productos
                                    </span>
                                    <svg class="w-5 h-5 text-pink-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Card Próximamente -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 opacity-75">
                    <div class="bg-gradient-to-br from-gray-500 to-gray-600 p-6">
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Módulos Futuros</h3>
                        <p class="text-gray-100">Pedidos, Usuarios, Cotizaciones y Reportes</p>
                    </div>
                    <div class="p-6">
                        <div class="w-full px-6 py-3 bg-gray-100 text-gray-500 rounded-xl text-center font-bold">
                            En Desarrollo
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>