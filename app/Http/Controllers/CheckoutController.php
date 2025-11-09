<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Carrito;
use App\Models\Pedido;
use App\Models\ItemPedido;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Inicia el proceso de checkout, creando el Pedido definitivo.
     */
    public function store()
    {
        // 1. Encontrar el carrito activo y sus ítems
        $carrito = Carrito::where('usuario_id', Auth::id())
                         ->where('estado', 'activo')
                         ->with('items')
                         ->first();

        if (!$carrito || $carrito->items->isEmpty()) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío o no es válido.');
        }

        // 2. Calcular el total
        $total = $carrito->items->sum('costo_final');

        // 3. Iniciar la transacción de base de datos
        DB::beginTransaction();

        try {
            // 4. Crear el Pedido maestro (Historial)
            $pedido = Pedido::create([
                'usuario_id' => Auth::id(),
                'estado' => 'pendiente_pago', // Estado inicial
                'total' => $total,
                'metodo_pago' => null, // Se definirá tras la API de pago
            ]);

            // 5. Mover los ítems del carrito al detalle del Pedido
            foreach ($carrito->items as $itemCarrito) {
                ItemPedido::create([
                    'pedido_id' => $pedido->id,
                    'cotizacion_id' => $itemCarrito->cotizacion_id,
                    'producto_id' => $itemCarrito->producto_id,
                    'cantidad' => $itemCarrito->cantidad,
                    'costo_final' => $itemCarrito->costo_final,
                    'ancho' => $itemCarrito->ancho,
                    'alto' => $itemCarrito->alto,
                    'requiere_diseno' => $itemCarrito->requiere_diseno,
                    'ruta_archivo' => $itemCarrito->ruta_archivo,
                ]);
            }

            // 6. Limpiar el Carrito (marcarlo como inactivo o "comprado")
            $carrito->estado = 'comprado';
            $carrito->save();
            
            DB::commit();

            // 7. Redirigir al cliente a la API de Pago
            // 🚨 NOTA: Aquí iría la lógica real de integración con la API de pago (Mercado Pago, Flow, etc.)
            // Por ahora, redirigimos a una página de confirmación con el ID del pedido.
            return redirect()->route('pedidos.show', $pedido->id) 
                             ->with('success', 'Pedido N°' . $pedido->id . ' creado. Redirigiendo a pago...');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Error en Checkout: " . $e->getMessage());
            return redirect()->route('carrito.index')->with('error', 'Hubo un error al procesar tu pedido. Intenta nuevamente.');
        }
    }
    
    // NOTA: Debes crear la ruta 'pedidos.show' y su respectiva vista.
}