<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;

    protected $table = 'cotizaciones'; 

    protected $fillable = [
        'usuario_id',
        'producto_id',
        'ancho',
        'alto',
        'cantidad',
        'estado',
    ];

    /**
     * Relación: Una cotización pertenece a un usuario (modelo User por defecto).
     */
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Una cotización pertenece a un producto.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
