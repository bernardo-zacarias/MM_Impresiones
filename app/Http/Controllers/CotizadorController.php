<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Producto; // Importamos el Modelo Producto
use App\Models\Cotizacion; // Importamos el Modelo Cotizacion
use App\Http\Controllers\Controller; // Aseguramos la herencia

class CotizadorController extends Controller
{
    /**
     * Muestra el formulario de cotización al cliente y carga los datos base.
     */
    public function index()
    {
        // 1. Cargar las REGLAS DE COTIZACIÓN
        $cotizaciones = Cotizacion::where('valor', '>', 0)
                                    ->with('producto') 
                                    ->get();

        // 2. Mapear la colección para que el frontend (cotizador.blade.php) la entienda
        $productosCotizables = $cotizaciones->map(function ($cotizacion) {
            return [
                'id' => $cotizacion->id, 
                'nombre' => $cotizacion->nombre . ($cotizacion->producto ? ' (' . $cotizacion->producto->nombre . ')' : ''),
                'valor_base' => $cotizacion->valor,
            ];
        });
        
        return view('cotizador.cotizador', compact('productosCotizables'));
    }

    /**
     * Procesa la solicitud de cotización del cliente (si no va directo al carrito).
     */
    public function cotizar(Request $request)
    {
        // Esta función recibe el POST si el cliente solo quiere una "solicitud de cotización"
        $validatedData = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'ancho' => 'required|numeric|min:0.01', 
            'alto' => 'required|numeric|min:0.01',
            'cantidad' => 'required|integer|min:1',
            'costo_final' => 'required|numeric|min:0', 
        ]);

        $producto = Producto::find($validatedData['producto_id']);
        
        Cotizacion::create([
            'usuario_id' => Auth::id(), 
            'producto_id' => $validatedData['producto_id'],
            'ancho' => $validatedData['ancho'],
            'alto' => $validatedData['alto'],
            'cantidad' => $validatedData['cantidad'],
            'estado' => 'pendiente', 
            
            'nombre' => 'SOLICITUD-' . $producto->nombre . '-' . time(), 
            'valor' => $validatedData['costo_final'], 
        ]);

        return back()->with('success', '¡Tu solicitud de cotización ha sido enviada con éxito! Un administrador la revisará pronto.');
    }
}