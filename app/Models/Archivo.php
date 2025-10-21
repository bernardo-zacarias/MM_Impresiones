<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;

    protected $table = 'archivos'; 

    protected $fillable = [
        'nombre_original',
        'ruta', 
        'mime_type',
        'cotizacion_id', 
        'pedido_id', 
    ];

    /**
     * Relación: El archivo puede pertenecer a una cotización.
     */
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

    /**
     * Relación: El archivo puede pertenecer a un pedido.
     */
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
