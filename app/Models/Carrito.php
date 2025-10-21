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
        'estado', // Ej: 'activo', 'comprado'
    ];

    /**
     * Relación: Un carrito pertenece a un usuario.
     */
    public function usuario()
    {
        // Asume que el modelo de usuario por defecto sigue siendo 'User'
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
