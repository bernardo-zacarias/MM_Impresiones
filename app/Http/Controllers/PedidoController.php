<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use App\Models\ItemPedido;

class PedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la página de confirmación y detalle de un pedido específico.
     */
    public function show(Pedido $pedido)
    {
        // 1. Seguridad: Asegurar que el usuario solo vea sus propios pedidos
        if ($pedido->usuario_id !== Auth::id()) {
            abort(403, 'No tienes permiso para ver este pedido.');
        }

        // 2. Cargar los detalles del pedido (ítems y sus relaciones)
        $items = $pedido->items()->with(['cotizacion.producto', 'producto'])->get();

        // 3. Retornar la vista de confirmación
        return view('pedidos.show', compact('pedido', 'items'));
    }

    /**
     * Muestra el historial completo de pedidos del usuario.
     */
    public function index()
    {
        $pedidos = Pedido::where('usuario_id', Auth::id())
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);
                          
        return view('pedidos.index', compact('pedidos'));
    }
}