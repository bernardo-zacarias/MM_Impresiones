<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $table = 'carritos'; 

    protected $fillable = [
        'usuario_id',
        'estado',
    ];

    /**
     * Relación: Un carrito pertenece a un usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Un carrito tiene muchos ítems.
     */
    public function items()
    {
        return $this->hasMany(ItemCarrito::class);
    }
}