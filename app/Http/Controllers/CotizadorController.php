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
        // Intentar cargar cotizaciones configuradas
        $cotizaciones = Cotizacion::where('valor', '>', 0)->get();

        // Si no hay cotizaciones, usar productos directamente
        if ($cotizaciones->isEmpty()) {
            $productos = Producto::where('precio', '>', 0)->get();
            $productosCotizables = $productos->map(function ($producto) {
                return [
                    'id' => $producto->id, 
                    'nombre' => $producto->nombre,
                    'valor_base' => $producto->precio,
                ];
            });
        } else {
            // Mapear cotizaciones existentes
            $productosCotizables = $cotizaciones->map(function ($cotizacion) {
                return [
                    'id' => $cotizacion->id, 
                    'nombre' => $cotizacion->nombre,
                    'valor_base' => $cotizacion->valor,
                ];
            });
        }
        
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