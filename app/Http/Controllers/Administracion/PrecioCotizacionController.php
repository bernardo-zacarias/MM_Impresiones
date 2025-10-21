<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cotizacion;
use App\Models\Producto;

class PrecioCotizacionController extends Controller
{
    /**
     * Muestra una lista de todas las cotizaciones.
     */
    public function index()
    {
        try {
            $cotizaciones = Cotizacion::paginate(10);
        } catch (\Throwable $e) {
            \Log::error("Error al cargar datos de cotización: " . $e->getMessage());
            $cotizaciones = collect([]);
        }

        return view('administracion.cotizaciones.index', compact('cotizaciones'));
    }

    /**
     * Muestra el formulario para crear una nueva cotización genérica.
     */
    public function create()
    {
        // Pasa 'null' si no hay un producto asociado, la vista lo manejará.
        $producto = null; 
        return view('administracion.cotizaciones.create', compact('producto'));
    }

    /**
     * Almacena un nuevo precio de cotización en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Lógica de validación
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'margen_porcentaje' => 'nullable|numeric|min:0|max:100',
            'fecha_validez' => 'nullable|date',
            'notas_cotizacion' => 'nullable|string',
            'producto_id' => 'nullable|exists:productos,id', 
        ]);

        // 2. Asignar usuario_id
        $validatedData['usuario_id'] = Auth::id();

        // 3. Crear la cotización
        Cotizacion::create($validatedData);

        return redirect()->route('administracion.cotizaciones.index')
                         ->with('success', 'Dato de Cotización creado exitosamente.');
    }

    /**
     * Muestra el precio especificado.
     */
    public function show(Cotizacion $cotizacion)
    {
        return view('administracion.cotizaciones.show', compact('cotizacion'));
    }

    /**
     * Muestra el formulario para editar el precio especificado.
     */
    public function edit(Cotizacion $cotizacion) 
    {
        // Carga el producto si existe. Si la relación es null, $producto será null.
        $producto = $cotizacion->producto; 
        
        // Pasa tanto la cotización como el producto (que puede ser null)
        return view('administracion.cotizaciones.edit', compact('cotizacion', 'producto'));
    }

    /**
     * Actualiza el precio especificado en la base de datos.
     */
    public function update(Request $request, Cotizacion $cotizacion) 
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255|unique:cotizaciones,nombre,' . $cotizacion->id, 
            'valor' => 'required|numeric|min:0',
            'margen_porcentaje' => 'nullable|numeric|min:0|max:100',
            'fecha_validez' => 'nullable|date',
            'notas_cotizacion' => 'nullable|string',
            'producto_id' => 'nullable|exists:productos,id', 
        ]);

        $cotizacion->update($validatedData);

        return redirect()->route('administracion.cotizaciones.index')
                         ->with('success', 'Dato de Cotización actualizado exitosamente.');
    }

    /**
     * Elimina el precio especificado de la base de datos.
     */
    public function destroy(Cotizacion $cotizacion) 
    {
        $cotizacion->delete();

        return redirect()->route('administracion.cotizaciones.index')
                         ->with('success', 'Dato de Cotización eliminado exitosamente.');
    }
    
    // Si usas esta ruta personalizada, mantenla. Si no, ignórala.
    public function createProductoCotizacion(Producto $producto)
    {
        return view('administracion.cotizaciones.create', compact('producto'));
    }
}
