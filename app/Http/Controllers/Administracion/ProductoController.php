<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // AGREGADO: Para gestión de archivos

class ProductoController extends Controller
{
    /**
     * Muestra una lista de todos los productos.
     */
    public function index()
    {
        $productos = Producto::with('categoria')->paginate(10); 
        return view('administracion.productos.index', compact('productos'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create()
    {
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
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // MODIFICADO para subir archivo
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $data = $request->all();

        // Lógica de subida de imagen
        if ($request->hasFile('imagen')) {
            // Guarda el archivo en storage/app/public/productos
            $rutaImagen = $request->file('imagen')->store('productos', 'public');
            $data['imagen'] = $rutaImagen; // Guarda la ruta relativa en la base de datos
        } else {
             $data['imagen'] = null;
        }

        Producto::create($data); 

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
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255|unique:productos,nombre,'.$producto->id,
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // MODIFICADO
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $data = $request->all();

        // Lógica de subida de imagen
        if ($request->hasFile('imagen')) {
            // 1. Eliminar la imagen antigua si existe
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            
            // 2. Guardar la nueva imagen
            $rutaImagen = $request->file('imagen')->store('productos', 'public');
            $data['imagen'] = $rutaImagen;
        } else if ($request->input('delete_imagen') == 1) { // Lógica para eliminar la imagen
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $data['imagen'] = null; // Establecer el campo en NULL en la base de datos
        }


        $producto->update($data);

        return redirect()->route('administracion.productos.index')
                         ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Elimina el producto especificado de la base de datos.
     */
    public function destroy(Producto $producto)
    {
        // Lógica para eliminar la imagen asociada al producto
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }
        
        $producto->delete();

        return redirect()->route('administracion.productos.index')
                         ->with('success', 'Producto eliminado exitosamente.');
    }
}
