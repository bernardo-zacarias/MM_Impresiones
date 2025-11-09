@extends('layouts.app')

@section('title', 'Catálogo de Productos')

{{-- Usamos la sección 'content' para el diseño principal --}}
@section('content')

    <div class="max-w-6xl mx-auto bg-white p-10 rounded-2xl shadow-2xl border border-gray-100">
        
        <h1 class="text-4xl font-extrabold text-gray-800 mb-2">Historial de Pedidos</h1>
        <p class="text-gray-600 mb-8 border-b pb-4">
            Aquí puedes ver el estado y el detalle de todas tus compras realizadas en MM Impresiones.
        </p>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if ($pedidos->isEmpty())
            <div class="p-10 bg-gray-50 rounded-xl shadow-inner text-center">
                <p class="text-xl text-gray-500">Aún no tienes pedidos registrados.</p>
                <a href="{{ route('catalogo.index') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800 font-medium underline">
                    Comienza a comprar
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach ($pedidos as $pedido)
                    <div class="bg-white p-5 rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition duration-200">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                            
                            <div class="mb-4 md:mb-0">
                                <h3 class="text-xl font-bold text-indigo-700">Pedido N° {{ $pedido->id }}</h3>
                                <p class="text-sm text-gray-500">Fecha: {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            
                            <div class="text-right">
                                <p class="text-3xl font-extrabold text-green-600 mb-1">
                                    ${{ number_format($pedido->total, 0, ',', '.') }}
                                </p>
                                <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full 
                                    {{ $pedido->estado == 'pagado' ? 'bg-green-100 text-green-700' : 
                                       ($pedido->estado == 'pendiente_pago' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                    {{ Str::title(str_replace('_', ' ', $pedido->estado)) }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-4 border-t pt-3 flex justify-end">
                            <a href="{{ route('pedidos.show', $pedido->id) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold flex items-center gap-1 transition">
                                Ver Detalle
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($pedidos->hasPages())
                <div class="mt-8">
                    {{ $pedidos->links() }}
                </div>
            @endif
        @endif
        
        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-800 font-medium underline">
                ← Volver al Panel de Cliente
            </a>
        </div>
    </div>
@endsection
