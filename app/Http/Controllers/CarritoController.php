<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // ¡Necesario para guardar archivos!
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
     * Agrega un ítem al carrito, manejando datos del Catálogo, Cotizador, y Archivo.
     */
    public function store(Request $request)
    {
        $isFromCatalogo = $request->filled('producto_id') && $request->has('opcion_archivo');
        
        // 1. Lógica de Validación Inteligente (Validación Condicional)
        $rules = [
            'cotizacion_id' => 'required|numeric', 
            'cantidad' => 'required|integer|min:1',
            'opcion_archivo' => 'nullable|in:subir,diseno', 
            'requiere_diseno' => 'nullable|boolean',
            
            // Reglas de IDs condicionales
            'producto_id' => $isFromCatalogo ? 'required|exists:productos,id' : 'nullable|numeric', 
            'cotizacion_id' => $isFromCatalogo ? 'nullable|numeric' : 'required|exists:cotizaciones,id',
            
            // Medidas/Costo Final son requeridos SOLO por el Cotizador
            'ancho' => $isFromCatalogo ? 'nullable|numeric' : 'required|numeric|min:0.01',
            'alto' => $isFromCatalogo ? 'nullable|numeric' : 'required|numeric|min:0.01',
            'costo_final' => $isFromCatalogo ? 'nullable|numeric' : 'required|numeric|min:0',
            
            // 🚨 VALIDACIÓN DEL ARCHIVO
            'archivo_diseno' => ['nullable', 'file', 'mimes:jpeg,png,pdf,ai,psd,zip', 'max:10240'], // Max 10MB
        ];

        $validated = $request->validate($rules);
        
        // 2. Inicialización, CÁLCULO y ASIGNACIÓN
        $carrito = $this->getOrCreateActiveCart();
        $ancho = $validated['ancho'] ?? 0;
        $alto = $validated['alto'] ?? 0;
        $subtotalCalculado = 0;
        $requiereDiseno = false;
        
        $finalProductoId = $validated['producto_id'] ?? null;
        $finalCotizacionId = $validated['cotizacion_id'] ?? null;
        $rutaArchivo = null; // Inicializamos la ruta del archivo

        // 3. LÓGICA DE CÁLCULO
        if (!$isFromCatalogo) {
            // A. FLUJO DE COTIZADOR
            $cotizacionBase = Cotizacion::find($finalCotizacionId);
            if (!$cotizacionBase) { return back()->with('error', 'Cotización base no encontrada.'); }

            $subtotalCalculado = $validated['costo_final'];
            $requiereDiseno = (bool)($validated['requiere_diseno'] ?? false);
            
        } else {
            // B. FLUJO DE CATÁLOGO
            $producto = Producto::find($finalProductoId);
            if (!$producto) { return back()->with('error', 'Producto de Catálogo no encontrado.'); }
            
            $requiereDiseno = ($validated['opcion_archivo'] === 'diseno');
            $costoDiseno = $requiereDiseno ? self::COSTO_DISENO : 0;
            $subtotalCalculado = ($producto->precio * $validated['cantidad']) + $costoDiseno;
            $ancho = $alto = 0;
            
            $cotizacionBase = Cotizacion::where('producto_id', $finalProductoId)->first();
            $finalCotizacionId = $cotizacionBase->id ?? null;
        }

        // 4. GUARDAR ARCHIVO
        if ($request->hasFile('archivo_diseno')) {
            // Guarda el archivo en storage/app/public/disenos_clientes (se crea si no existe)
            $rutaArchivo = $request->file('archivo_diseno')->store('disenos_clientes', 'public');
        }

        // 5. Creación del Ítem (Guardando la ruta)
        ItemCarrito::create([
            'carrito_id' => $carrito->id,
            'cotizacion_id' => $finalCotizacionId, 
            'producto_id' => $finalProductoId, 
            'ancho' => $ancho, 
            'alto' => $alto,  
            'cantidad' => $validated['cantidad'],
            'costo_final' => $subtotalCalculado,
            'requiere_diseno' => $requiereDiseno,
            'ruta_archivo' => $rutaArchivo, // 🚨 GUARDAMOS LA RUTA AQUÍ
        ]);

        return redirect()->route('carrito.index')->with('success', 'Ítem añadido al carrito.');
    }

    public function destroy(ItemCarrito $item)
    {
        // ... (se mantiene igual)
        if ($item->carrito->usuario_id !== Auth::id() || $item->carrito->estado !== 'activo') {
             return back()->with('error', 'El ítem no pertenece a tu carrito activo.');
        }

        $item->delete();
        
        return back()->with('success', 'Ítem eliminado del carrito.');
    }
}