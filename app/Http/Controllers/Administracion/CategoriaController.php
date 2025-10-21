<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Categoria; // Importamos el modelo
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Muestra una lista de todas las categorias.
     */
    public function index()
    {
        // CAMBIO CRÍTICO: Usar paginate() en lugar de all() para que la vista index funcione
        $categorias = Categoria::paginate(10); 
        
        return view('administracion.categorias.index', compact('categorias')); 
    }

    /**
     * Muestra el formulario para crear una nueva categoria.
     */
    public function create()
    {
        return view('administracion.categorias.create');
    }

    /**
     * Almacena una nueva categoria en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
            'descripcion' => 'nullable|string',
        ]);

        // 2. Creación del modelo
        Categoria::create($request->all());

        // 3. Redirección (Ahora que index funciona, esta redirección funcionará)
        return redirect()->route('administracion.categorias.index')
                         ->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Muestra el formulario para editar la categoria especificada.
     */
    public function edit(Categoria $categoria)
    {
        return view('administracion.categorias.edit', compact('categoria')); 
    }

    /**
     * Actualiza la categoria especificada en la base de datos.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre,'.$categoria->id,
            'descripcion' => 'nullable|string',
        ]);

        $categoria->update($request->all());

        return redirect()->route('administracion.categorias.index')
                         ->with('success', 'Categoría actualizada exitosamente.');
    }
    
    /**
     * Elimina la categoria especificada de la base de datos.
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()->route('administracion.categorias.index')
                         ->with('success', 'Categoría eliminada exitosamente.');
    }
}
