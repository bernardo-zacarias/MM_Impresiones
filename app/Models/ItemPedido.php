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
        'producto_nombre', // Nombre del producto (guardado)
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
    
    // Atributo para obtener el nombre del producto
    public function getProductoNombreAttribute($value)
    {
        // Si ya está guardado en la BD, usarlo
        if ($value) {
            return $value;
        }
        
        // Si no, intentar obtenerlo de las relaciones
        if ($this->producto_id && $this->producto) {
            return $this->producto->nombre;
        }
        if ($this->cotizacion_id && $this->cotizacion) {
            return $this->cotizacion->nombre;
        }
        
        return 'Producto';
    }

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