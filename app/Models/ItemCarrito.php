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
        'cotizacion_id',
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

    /**
     * Relación: Un ítem pertenece a un carrito.
     */
    public function carrito()
    {
        return $this->belongsTo(Carrito::class);
    }

    /**
     * Relación: Un ítem está basado en un registro de Cotización.
     */
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }
}