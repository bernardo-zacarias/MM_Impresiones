<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    /**
     * Muestra el listado de productos agrupados por categoría.
     */
    public function index()
    {
        // Carga todas las categorías con sus productos asociados (eager loading)
        // Esto optimiza la consulta a la base de datos.
        $categorias = Categoria::with('productos')->get();

        return view('catalogo.index', compact('categorias'));
    }

    /**
     * Muestra los detalles de un producto individual.
     */
    public function show(Producto $producto)
    {
        return view('catalogo.show', compact('producto'));
    }
}