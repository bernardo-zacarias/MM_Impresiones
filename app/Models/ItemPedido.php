<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    use HasFactory;

    protected $table = 'items_pedido'; 

    protected $fillable = [
        'pedido_id',
        'cotizacion_id', // ID del ítem cotizable
        'producto_id',   // ID del producto de catálogo
        'ancho',
        'alto',
        'cantidad',
        'costo_final',
        'ruta_archivo',
        'requiere_diseno',
    ];

    protected $casts = [
        'requiere_diseno' => 'boolean',
        'costo_final' => 'float',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
    
    // Relación al producto fijo de catálogo
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Relación al ítem cotizable
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }
}