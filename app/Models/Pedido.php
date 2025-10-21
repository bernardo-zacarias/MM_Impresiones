<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos'; 

    protected $fillable = [
        'usuario_id',
        'estado',
        'total',
        'metodo_pago',
    ];

    /**
     * Relación: Un pedido pertenece a un usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Un pedido tiene muchos ítems (productos) de pedido.
     */
    public function items()
    {
        return $this->hasMany(ItemPedido::class);
    }
}
