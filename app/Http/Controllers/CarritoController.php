<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Carrito;
use App\Models\ItemCarrito;
use App\Models\Cotizacion;
use App\Models\Producto;
use App\Http\Controllers\Controller; 

class CarritoController extends Controller
{
    // 1. DEFINICIÓN DE LA CONSTANTE (CORRECCIÓN DE SINTAXIS PHP)
    const COSTO_DISENO = 10000;

    // Aseguramos que solo usuarios autenticados puedan usar el carrito.
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    /**
     * Obtiene el carrito activo del usuario actual o lo crea si no existe.
     */
    protected function getOrCreateActiveCart()
    {
        return Carrito::firstOrCreate(
            ['usuario_id' => Auth::id(), 'estado' => 'activo'],
            ['usuario_id' => Auth::id(), 'estado' => 'activo']
        );
    }

    /**
     * Muestra el contenido del carrito del cliente.
     */
    public function index()
    {
        $carrito = $this->getOrCreateActiveCart();
        $items = $carrito->items()->with('cotizacion.producto')->get();
        
        $total = $items->sum('costo_final'); 

        return view('carrito.carrito', compact('carrito', 'items', 'total'));
    }

    /**
     * Agrega un ítem al carrito, manejando datos del Catálogo y del Cotizador.
     */
    public function store(Request $request)
    {
        // Determinamos la fuente analizando los datos que trae el request.
        // Si tiene 'opcion_archivo' (radio button), viene del Catálogo (show.blade.php).
        $isFromCatalogo = $request->has('opcion_archivo');
        
        // 1. Lógica de Validación Inteligente (Validación Condicional)
        $rules = [
            'cotizacion_id' => 'required|numeric', 
            'cantidad' => 'required|integer|min:1',
            
            // Reglas específicas para el Catálogo (Obligatorio en Catálogo)
            'opcion_archivo' => 'nullable|in:subir,diseno', 
            
            // Reglas condicionales: Requeridas SOLO si NO viene del Catálogo
            'ancho' => $isFromCatalogo ? 'nullable|numeric' : 'required|numeric|min:0.01',
            'alto' => $isFromCatalogo ? 'nullable|numeric' : 'required|numeric|min:0.01',
            'costo_final' => $isFromCatalogo ? 'nullable|numeric' : 'required|numeric|min:0',
            
            'requiere_diseno' => 'nullable|boolean',
        ];

        $validated = $request->validate($rules);
        
        // 2. Obtener datos base y carrito
        $carrito = $this->getOrCreateActiveCart();
        $cotizacionBase = Cotizacion::find($validated['cotizacion_id']);
        
        $ancho = $validated['ancho'] ?? 0;
        $alto = $validated['alto'] ?? 0;
        $subtotalCalculado = 0;
        $requiereDiseno = false;
        
        // 3. DETERMINACIÓN DE LA FUENTE Y CÁLCULO
        
        // Caso A: VIENE DEL COTIZADOR (Tiene medidas/costo_final requeridos)
        if (!$isFromCatalogo) {
            $subtotalCalculado = $validated['costo_final'];
            $requiereDiseno = (bool)($validated['requiere_diseno'] ?? false); 

        // Caso B: VIENE DEL CATÁLOGO (Usamos el producto asociado a la cotización base)
        } elseif ($cotizacionBase && $cotizacionBase->producto_id) {
            $producto = Producto::find($cotizacionBase->producto_id);
            if (!$producto) {
                return back()->with('error', 'El producto asociado al catálogo no existe.');
            }
            
            // El campo que llega del Catálogo es 'opcion_archivo'
            $requiereDiseno = ($validated['opcion_archivo'] === 'diseno');
            $costoDiseno = $requiereDiseno ? self::COSTO_DISENO : 0;
            
            // Cálculo: (Precio de Catálogo * Cantidad) + Costo Diseño
            $subtotalCalculado = ($producto->precio * $validated['cantidad']) + $costoDiseno;
            
            // Forzar medidas a 0 para el Catálogo
            $ancho = 0;
            $alto = 0;
        } else {
             // Fallback: Si el ID no es ni Cotización completa, ni Producto de Catálogo
             return back()->with('error', 'No se pudo determinar el origen del pedido o el ID es inválido.');
        }

        // 4. Crear el ítem del carrito
        ItemCarrito::create([
            'carrito_id' => $carrito->id,
            'cotizacion_id' => $validated['cotizacion_id'],
            'ancho' => $ancho, 
            'alto' => $alto,  
            'cantidad' => $validated['cantidad'],
            'costo_final' => $subtotalCalculado,
            'requiere_diseno' => $requiereDiseno,
        ]);

        // 5. Redirigir (¡Ahora sí debe funcionar la navegación!)
        return redirect()->route('carrito.index')->with('success', 'Ítem añadido al carrito.');
    }

    /**
     * Elimina un ítem específico del carrito.
     */
    public function destroy(ItemCarrito $item)
    {
        if ($item->carrito->usuario_id !== Auth::id() || $item->carrito->estado !== 'activo') {
             return back()->with('error', 'El ítem no pertenece a tu carrito activo.');
        }

        $item->delete();
        
        return back()->with('success', 'Ítem eliminado del carrito.');
    }
}