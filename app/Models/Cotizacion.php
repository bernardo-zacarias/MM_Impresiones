<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Asegúrate de importar los modelos relacionados
use App\Models\User; 
use App\Models\Producto; 

class Cotizacion extends Model
{
    use HasFactory;
    
    // Especificar el nombre de la tabla
    protected $table = 'cotizaciones'; 

    // Columnas que se pueden llenar masivamente
    protected $fillable = [
        'nombre',
        'valor',
        'margen_porcentaje',
        'fecha_validez',
        'notas_cotizacion',
        'usuario_id',
        'producto_id', 
    ];

    // Casteo de tipos
    protected $casts = [
        'valor' => 'float',
        'margen_porcentaje' => 'float',
        'fecha_validez' => 'date',
    ];

    // =======================================================
    // NUEVA FUNCIÓN SOLICITADA: ACCESOR PARA PRECIO CON MARGEN
    // =======================================================

    /**
     * Obtiene el precio final aplicando el margen de porcentaje.
     * Accesor usado con $cotizacion->precio_con_margen
     * @return float
     */
    public function getPrecioConMargenAttribute()
    {
        // Si no hay valor o margen, retorna el valor base o 0.0
        if (is_null($this->valor) || is_null($this->margen_porcentaje)) {
            return $this->valor ?? 0.0;
        }

        // Calcula el precio con el margen
        $margen = $this->valor * ($this->margen_porcentaje / 100);
        return round($this->valor + $margen, 2); // Redondeamos a 2 decimales
    }


    // =======================================================
    // RELACIONES
    // =======================================================

    public function producto()
    {
        // Una cotización pertenece a un producto (producto_id)
        return $this->belongsTo(Producto::class);
    }

    public function usuario()
    {
        // Una cotización fue creada por un usuario (usuario_id)
        return $this->belongsTo(User::class);
    }
}
