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
        // 1. Cargar las REGLAS DE COTIZACIÓN (los ítems cotizables definidos por el admin)
        // Filtramos por valor > 0 para excluir las solicitudes de cliente (que no tienen valor real)
        $cotizaciones = Cotizacion::where('valor', '>', 0)
                                    ->with('producto') // Cargamos la relación si existe
                                    ->get();

        // 2. Mapear la colección para que el frontend (cotizador.blade.php) la entienda
        // La vista espera la variable $productosCotizables
        $productosCotizables = $cotizaciones->map(function ($cotizacion) {
            return [
                // Usamos el ID del registro de Cotización, no del Producto
                'id' => $cotizacion->id, 
                // Usamos el NOMBRE de la Cotización. Si está asociado a un producto, lo concatenamos.
                'nombre' => $cotizacion->nombre . ($cotizacion->producto ? ' (' . $cotizacion->producto->nombre . ')' : ''),
                // Usamos el campo 'valor' del registro de Cotización como el precio base por m²
                'valor_base' => $cotizacion->valor,
                // Puedes añadir margen_porcentaje si lo vas a calcular en el JS
                // 'margen_porcentaje' => $cotizacion->margen_porcentaje ?? 0, 
            ];
        });
        
        // 3. Pasamos la variable $productosCotizables a la vista.
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