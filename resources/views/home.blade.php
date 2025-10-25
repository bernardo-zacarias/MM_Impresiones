<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - MM Impresiones</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
@extends('layouts.app')

<body class="bg-gradient-to-br from-gray-50 to-indigo-50 min-h-screen">

    <div class="max-w-7xl mx-auto p-8">
        
        <!-- Mensajes de Éxito/Error -->
        @if (session('success'))
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 px-6 py-4 rounded-xl relative mb-8 shadow-lg animate-fade-in">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-green-700 font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        
        @if (session('error'))
            <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 px-6 py-4 rounded-xl relative mb-8 shadow-lg">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-red-700 font-semibold">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @auth
            <!-- Header del Perfil -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 mb-8">
                <div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-indigo-700 p-8 relative overflow-hidden">
                    <!-- Decoración de fondo -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full -translate-x-32 -translate-y-32"></div>
                        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-32 translate-y-32"></div>
                    </div>

                    <div class="relative flex flex-col md:flex-row items-center gap-6">
                        <!-- Avatar -->
                        <div class="relative">
                            <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center shadow-2xl border-4 border-white/50">
                                <span class="text-5xl font-bold text-indigo-600">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                            </div>
                            <div class="absolute bottom-0 right-0 w-10 h-10 bg-green-500 rounded-full border-4 border-white flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Información del Usuario -->
                        <div class="flex-1 text-center md:text-left">
                            <h1 class="text-4xl font-extrabold text-white mb-2">
                                ¡Hola, {{ Auth::user()->name }}!
                            </h1>
                            <p class="text-indigo-100 text-lg mb-3">{{ Auth::user()->email }}</p>
                            <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                                <span class="px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-semibold flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ ucfirst(Auth::user()->rol) }}
                                </span>
                                <span class="px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-semibold flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Miembro desde {{ Auth::user()->created_at->format('M Y') }}
                                </span>
                            </div>
                        </div>

                        <!-- Botones de Acción Rápida -->
                        <div class="flex flex-col gap-2">
                            <button class="px-6 py-2 bg-white text-indigo-600 rounded-xl font-semibold hover:bg-indigo-50 transition-all shadow-lg flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Editar Perfil
                            </button>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full px-6 py-2 bg-white/10 backdrop-blur-sm text-white rounded-xl font-semibold hover:bg-white/20 transition-all border border-white/30 flex items-center gap-2 justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid de Contenido -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Columna Izquierda: Información Personal -->
                <div class="lg:col-span-1 space-y-6">
                    
                    <!-- Card de Información Personal -->
                    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-1 h-8 bg-gradient-to-b from-indigo-500 to-purple-500 rounded-full"></div>
                            <h2 class="text-2xl font-bold text-gray-800">Información Personal</h2>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                                <svg class="w-5 h-5 text-indigo-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 font-semibold">Email</p>
                                    <p class="text-gray-800 font-medium">{{ Auth::user()->email }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                                <svg class="w-5 h-5 text-indigo-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 font-semibold">Teléfono</p>
                                    <p class="text-gray-800 font-medium">{{ Auth::user()->telefono ?? 'No registrado' }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                                <svg class="w-5 h-5 text-indigo-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 font-semibold">Ubicación</p>
                                    <p class="text-gray-800 font-medium">
                                        {{ Auth::user()->ciudad ?? 'N/A' }}, {{ Auth::user()->comuna ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card de Estadísticas -->
                    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-xl p-6 text-white">
                        <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Mis Estadísticas
                        </h3>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                                <p class="text-3xl font-bold">0</p>
                                <p class="text-sm opacity-90">Pedidos</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                                <p class="text-3xl font-bold">$0</p>
                                <p class="text-sm opacity-90">Gastado</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                                <p class="text-3xl font-bold">0</p>
                                <p class="text-sm opacity-90">Cotizaciones</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                                <p class="text-3xl font-bold">0</p>
                                <p class="text-sm opacity-90">Favoritos</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Acciones y Actividad -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Accesos Rápidos -->
                    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-1 h-8 bg-gradient-to-b from-indigo-500 to-purple-500 rounded-full"></div>
                            <h2 class="text-2xl font-bold text-gray-800">Accesos Rápidos</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            @if (Auth::user()->rol === 'admin')
                                <!-- Botón Admin -->
                                <a href="{{ route('administracion.categorias.index') }}" class="group relative block overflow-hidden rounded-xl bg-gradient-to-br from-red-600 via-red-500 to-pink-600 p-0.5 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                                    <div class="relative bg-gradient-to-br from-red-600 to-pink-600 rounded-xl overflow-hidden">
                                        <div class="relative px-6 py-4 flex items-center gap-3">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <div class="flex-1 text-left">
                                                <p class="text-white font-bold text-lg">Panel Admin</p>
                                                <p class="text-white/80 text-sm">Administrar sistema</p>
                                            </div>
                                            <svg class="w-6 h-6 text-white group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            @endif

                            <!-- Botón Catálogo -->
                            <a href="{{ route('catalogo.index') }}" class="group relative block overflow-hidden rounded-xl bg-gradient-to-br from-indigo-600 via-indigo-500 to-purple-600 p-0.5 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                                <div class="relative bg-white rounded-xl overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <div class="relative px-6 py-4 flex items-center gap-3">
                                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                        <div class="flex-1 text-left">
                                            <p class="font-bold text-gray-800 text-lg">Ver Catálogo</p>
                                            <p class="text-gray-600 text-sm">Explorar productos</p>
                                        </div>
                                        <svg class="w-6 h-6 text-indigo-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                        </svg>
                                    </div>
                                </div>
                            </a>

                            <!-- Botón Cotizador -->
                            <a href="{{ route('cotizador.index') }}" class="group relative block overflow-hidden rounded-xl bg-gradient-to-br from-purple-600 via-purple-500 to-pink-600 p-0.5 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                                <div class="relative bg-white rounded-xl overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-pink-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <div class="relative px-6 py-4 flex items-center gap-3">
                                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <div class="flex-1 text-left">
                                            <p class="font-bold text-gray-800 text-lg">Cotizador</p>
                                            <p class="text-gray-600 text-sm">Solicitar presupuesto</p>
                                        </div>
                                        <svg class="w-6 h-6 text-purple-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                        </svg>
                                    </div>
                                </div>
                            </a>

                            <!-- Botón Carrito -->
                            <a href="{{ route('carrito.index') }}" class="group relative block overflow-hidden rounded-xl bg-gradient-to-br from-green-600 via-green-500 to-emerald-600 p-0.5 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                                <div class="relative bg-white rounded-xl overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-emerald-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <div class="relative px-6 py-4 flex items-center gap-3">
                                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <div class="flex-1 text-left">
                                            <p class="font-bold text-gray-800 text-lg">Mi Carrito</p>
                                            <p class="text-gray-600 text-sm">Ver productos</p>
                                        </div>
                                        <svg class="w-6 h-6 text-green-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Historial de Pedidos -->
                    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-8 bg-gradient-to-b from-indigo-500 to-purple-500 rounded-full"></div>
                                <h2 class="text-2xl font-bold text-gray-800">Historial de Pedidos</h2>
                            </div>
                            <button class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm flex items-center gap-1">
                                Ver todos
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Estado Vacío -->
                        <div class="text-center py-12">
                            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <h3 class="text-xl font-bold text-gray-600 mb-2">No tienes pedidos aún</h3>
                            <p class="text-gray-500 mb-6">Comienza a explorar nuestro catálogo</p>
                            <a href="{{ route('catalogo.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                Ver Productos
                            </a>
                        </div>
                    </div>

                    <!-- Cotizaciones Recientes -->
                    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded-full"></div>
                                <h2 class="text-2xl font-bold text-gray-800">Cotizaciones Recientes</h2>
                            </div>
                        </div>

                        <!-- Estado Vacío -->
                        <div class="text-center py-12">
                            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="text-xl font-bold text-gray-600 mb-2">No tienes cotizaciones</h3>
                            <p class="text-gray-500 mb-6">Solicita un presupuesto personalizado</p>
                            <a href="{{ route('cotizador.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-purple-600 text-white rounded-xl font-semibold hover:bg-purple-700 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                Solicitar Cotización
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <!-- Contenido para usuarios NO autenticados -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-br from-indigo-600 to-purple-600 p-16 text-center">
                    <div class="inline-block p-6 bg-white/20 rounded-3xl backdrop-blur-sm mb-6">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h1 class="text-5xl font-extrabold text-white mb-4">
                        Bienvenido a MM Impresiones
                    </h1>
                    <p class="text-xl text-indigo-100 mb-8">
                        Crea tu cuenta y comienza a disfrutar de nuestros servicios
                    </p>
                </div>

                <div class="p-12 text-center">
                    <div class="max-w-3xl mx-auto">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                            <div class="p-6 bg-indigo-50 rounded-2xl">
                                <svg class="w-12 h-12 text-indigo-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                <h3 class="font-bold text-gray-800 mb-2">Rápido y Fácil</h3>
                                <p class="text-sm text-gray-600">Procesos optimizados para tu comodidad</p>
                            </div>
                            <div class="p-6 bg-purple-50 rounded-2xl">
                                <svg class="w-12 h-12 text-purple-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <h3 class="font-bold text-gray-800 mb-2">100% Seguro</h3>
                                <p class="text-sm text-gray-600">Tus datos están protegidos</p>
                            </div>
                            <div class="p-6 bg-pink-50 rounded-2xl">
                                <svg class="w-12 h-12 text-pink-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                </svg>
                                <h3 class="font-bold text-gray-800 mb-2">Alta Calidad</h3>
                                <p class="text-sm text-gray-600">Productos premium garantizados</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <a href="{{ route('register') }}" class="group relative block overflow-hidden rounded-xl bg-gradient-to-br from-indigo-600 via-indigo-500 to-purple-600 p-0.5 shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105">
                                <div class="relative bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <div class="relative px-12 py-5 flex items-center justify-center gap-3">
                                        <svg class="w-6 h-6 text-white group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                        </svg>
                                        <span class="text-2xl font-bold text-white">
                                            Crear Cuenta Gratis
                                        </span>
                                        <svg class="w-6 h-6 text-white group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                        </svg>
                                    </div>
                                </div>
                            </a>

                            <p class="text-gray-600">
                                ¿Ya tienes una cuenta? 
                                <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-purple-600 transition-colors inline-flex items-center gap-1 group">
                                    Inicia Sesión Aquí
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endauth
    </div>

</body>
</html>