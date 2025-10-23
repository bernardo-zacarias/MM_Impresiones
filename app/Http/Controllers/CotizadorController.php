<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Producto; // Importamos el Modelo Producto
use App\Models\Cotizacion; // Importamos el Modelo Cotizacion

class CotizadorController extends Controller
{
    /**
     * Muestra el formulario de cotización al cliente y carga los datos base.
     */
    public function index()
    {
        // 1. Obtener los productos: ID, Nombre, y el Precio (que es el valor base por m²)
        $productos = Producto::all(['id', 'nombre', 'precio']);

        // 2. Mapear para crear la variable $productosCotizables que espera la vista
        $productosCotizables = $productos->map(function ($producto) {
            return [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                // CRUCIAL: 'valor_base' es el nombre del atributo que usa el JS en cotizador.blade.php
                'valor_base' => $producto->precio, 
            ];
        });
        
        // 3. Pasar la variable con el nombre correcto a la vista
        return view('cotizador.cotizador', compact('productosCotizables'));
    }

    /**
     * Procesa la solicitud de cotización del cliente (si no va directo al carrito).
     */
    public function cotizar(Request $request)
    {
        // NOTA: Esta función es necesaria si el formulario HTML usa esta ruta POST.
        // Si el formulario en cotizador.blade.php apunta a '/carrito', esta función no se usa directamente.
        
        $validatedData = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'ancho' => 'required|numeric|min:0.01', 
            'alto' => 'required|numeric|min:0.01',
            'cantidad' => 'required|integer|min:1',
            'costo_final' => 'required|numeric|min:0', // El costo calculado por JS
            // No validamos 'requiere_diseno' porque se convierte en nota.
        ]);

        $producto = Producto::find($validatedData['producto_id']);
        
        Cotizacion::create([
            'usuario_id' => Auth::id(), 
            'producto_id' => $validatedData['producto_id'],
            'ancho' => $validatedData['ancho'],
            'alto' => $validatedData['alto'],
            'cantidad' => $validatedData['cantidad'],
            'estado' => 'pendiente', 
            
            // Asignamos valores a campos NOT NULL requeridos por el CRUD Admin
            'nombre' => 'SOLICITUD-' . $producto->nombre . '-' . time(), 
            'valor' => $validatedData['costo_final'], // Usamos el costo_final como valor de la cotización pendiente
            // Los campos margen_porcentaje y fecha_validez pueden quedar null.
        ]);

        return back()->with('success', '¡Tu solicitud de cotización ha sido enviada con éxito! Un administrador la revisará pronto.');
    }
}