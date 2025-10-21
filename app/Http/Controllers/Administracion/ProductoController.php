<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Producto; // Importamos el Modelo Producto
use App\Models\Categoria; // Importamos el Modelo Categoria
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Muestra una lista de todos los productos.
     */
    public function index()
    {
        // Paginamos para evitar cargar demasiados datos
        $productos = Producto::with('categoria')->paginate(10); 
        return view('administracion.productos.index', compact('productos'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create()
    {
        // Necesitamos todas las categorías para el menú desplegable (dropdown)
        $categorias = Categoria::all(); 
        return view('administracion.productos.create', compact('categorias'));
    }

    /**
     * Almacena un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255|unique:productos,nombre',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|string|url', // Asumiendo URL de imagen por simplicidad
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        Producto::create($request->all());

        return redirect()->route('administracion.productos.index')
                         ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Muestra el producto especificado (función opcional).
     */
    public function show(Producto $producto)
    {
        return view('administracion.productos.show', compact('producto'));
    }

    /**
     * Muestra el formulario para editar el producto especificado.
     */
    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        return view('administracion.productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Actualiza el producto especificado en la base de datos.
     */
    public function update(Request $request, Producto $producto)
    {
        // Validación de datos, ignorando el nombre del producto actual en la validación unique
        $request->validate([
            'nombre' => 'required|string|max:255|unique:productos,nombre,'.$producto->id,
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|string|url',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $producto->update($request->all());

        return redirect()->route('administracion.productos.index')
                         ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Elimina el producto especificado de la base de datos.
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('administracion.productos.index')
                         ->with('success', 'Producto eliminado exitosamente.');
    }
}
