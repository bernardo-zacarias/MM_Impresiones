<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido; // Importamos el modelo de Pedido
use App\Models\Cotizacion; // Importamos el modelo de Cotizacion

class HomeController extends Controller
{
    /**
     * Muestra el dashboard de cliente (home.blade.php).
     */
    public function index()
    {
        // 1. Obtener Pedidos Recientes (Historial de Compras)
        // Solo mostramos pedidos que NO están en estado 'comprado' o 'activo' del carrito.
        $pedidosRecientes = Pedido::where('usuario_id', Auth::id())
                                    ->whereIn('estado', ['pendiente_pago', 'pagado', 'en_proceso'])
                                    ->orderBy('created_at', 'desc')
                                    ->take(3) // Tomamos solo los 3 más recientes
                                    ->get();

        // 2. Obtener Cotizaciones Recientes (Solicitudes enviadas)
        // Mostramos las últimas 3 solicitudes enviadas por el cliente.
        $cotizacionesRecientes = Cotizacion::where('usuario_id', Auth::id())
                                          ->orderBy('created_at', 'desc')
                                          ->take(3)
                                          ->get();

        // 3. Pasar los datos a la vista home.blade.php
        return view('home', compact('pedidosRecientes', 'cotizacionesRecientes'));
    }
}