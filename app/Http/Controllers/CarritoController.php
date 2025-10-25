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
    const COSTO_DISENO = 10000;

    public function __construct()
    {
        $this->middleware('auth'); 
    }

    protected function getOrCreateActiveCart()
    {
        return Carrito::firstOrCreate(
            ['usuario_id' => Auth::id(), 'estado' => 'activo'],
            ['usuario_id' => Auth::id(), 'estado' => 'activo']
        );
    }

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
        // 1. Detección de Origen: Se asume Catálogo si producto_id está lleno.
        $isFromCatalogo = $request->filled('producto_id') && $request->has('opcion_archivo');
        
        // 2. Lógica de Validación Inteligente (Validación Condicional)
        $rules = [
            'cantidad' => 'required|integer|min:1',
            'opcion_archivo' => 'nullable|in:subir,diseno', 
            'requiere_diseno' => 'nullable|boolean',
            
            // Si es Catálogo: producto_id es requerido, cotizacion_id es opcional (null)
            'producto_id' => $isFromCatalogo ? 'required|exists:productos,id' : 'nullable|numeric', 
            
            // Si es Cotizador: cotizacion_id es requerido, producto_id es opcional (null)
            'cotizacion_id' => $isFromCatalogo ? 'nullable|numeric' : 'required|exists:cotizaciones,id',
            
            // Medidas/Costo Final son requeridos SOLO por el Cotizador
            'ancho' => $isFromCatalogo ? 'nullable|numeric' : 'required|numeric|min:0.01',
            'alto' => $isFromCatalogo ? 'nullable|numeric' : 'required|numeric|min:0.01',
            'costo_final' => $isFromCatalogo ? 'nullable|numeric' : 'required|numeric|min:0',
        ];

        $validated = $request->validate($rules);
        
        // 3. Inicialización y Búsqueda
        $carrito = $this->getOrCreateActiveCart();
        $ancho = $validated['ancho'] ?? 0;
        $alto = $validated['alto'] ?? 0;
        $subtotalCalculado = 0;
        $requiereDiseno = false;
        
        // El ID del producto o cotización que vamos a guardar
        $finalProductoId = $validated['producto_id'] ?? null;
        $finalCotizacionId = $validated['cotizacion_id'] ?? null;
        
        // 4. CÁLCULO Y ASIGNACIÓN
        
        if ($isFromCatalogo) {
            // A. FLUJO DE CATÁLOGO
            
            $producto = Producto::find($finalProductoId);
            if (!$producto) { return back()->with('error', 'Producto de Catálogo no encontrado.'); }

            $requiereDiseno = ($validated['opcion_archivo'] === 'diseno');
            $costoDiseno = $requiereDiseno ? self::COSTO_DISENO : 0;
            
            $subtotalCalculado = ($producto->precio * $validated['cantidad']) + $costoDiseno;
            $ancho = $alto = 0;
            
            // 🚨 AJUSTE: Buscamos un ID de cotización para la FK (debe ser nullable en Items_Carrito)
            $cotizacionBase = Cotizacion::where('producto_id', $finalProductoId)->first();
            $finalCotizacionId = $cotizacionBase->id ?? null; // Usamos el ID del registro Cotización si existe
            
        } else {
            // B. FLUJO DE COTIZADOR
            
            $cotizacionBase = Cotizacion::find($finalCotizacionId);
            if (!$cotizacionBase) { return back()->with('error', 'Cotización base no encontrada.'); }

            $subtotalCalculado = $validated['costo_final'];
            $requiereDiseno = (bool)($validated['requiere_diseno'] ?? false);
            
            $finalProductoId = null; // Aseguramos que la FK de producto sea nula
        }

        // 5. Creación del Ítem (Solo uno de los IDs estará lleno)
        ItemCarrito::create([
            'carrito_id' => $carrito->id,
            'cotizacion_id' => $finalCotizacionId, 
            'producto_id' => $finalProductoId, 
            'ancho' => $ancho, 
            'alto' => $alto,  
            'cantidad' => $validated['cantidad'],
            'costo_final' => $subtotalCalculado,
            'requiere_diseno' => $requiereDiseno,
        ]);

        return redirect()->route('carrito.index')->with('success', 'Ítem añadido al carrito.');
    }

    public function destroy(ItemCarrito $item)
    {
        if ($item->carrito->usuario_id !== Auth::id() || $item->carrito->estado !== 'activo') {
             return back()->with('error', 'El ítem no pertenece a tu carrito activo.');
        }

        $item->delete();
        
        return back()->with('success', 'Ítem eliminado del carrito.');
    }
}