<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCarrito extends Model
{
    use HasFactory;

    protected $table = 'items_carrito';

    protected $fillable = [
        'carrito_id',
        'cotizacion_id', // Para ítems de producto variable (cotizado)
        'producto_id',   // Para ítems de producto fijo (catálogo)
        'ancho',
        'alto',
        'cantidad',
        'costo_final',
        'requiere_diseno',
    ];

    protected $casts = [
        'requiere_diseno' => 'boolean',
        'costo_final' => 'float',
    ];

    public function carrito()
    {
        return $this->belongsTo(Carrito::class);
    }
    
    // Relación al producto fijo de catálogo
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Relación al producto variable de cotización
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

    // Método para obtener el nombre del ítem, sin importar su origen
    public function getNombreItemAttribute()
    {
        if ($this->producto_id) {
            return $this->producto->nombre ?? 'Producto Catálogo';
        }
        if ($this->cotizacion_id) {
            return $this->cotizacion->nombre ?? 'Producto Cotizable';
        }
        return 'Ítem Desconocido';
    }
}