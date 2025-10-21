<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Especificamos la tabla si el nombre no sigue la convención en inglés
    protected $table = 'categorias'; 

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Relación: Una categoría tiene muchos productos.
     */
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
