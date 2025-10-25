<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items_carrito', function (Blueprint $table) {
            $table->id();
            // Clave foránea al Carrito
            $table->foreignId('carrito_id')->constrained('carritos')->onDelete('cascade');
            
            // Clave foránea a la Cotización (Define el producto y precio base)
            $table->foreignId('cotizacion_id')->constrained('cotizaciones')->onDelete('cascade');
            
            // Datos del cálculo de cotización
            $table->float('ancho')->nullable();
            $table->float('alto')->nullable();
            $table->integer('cantidad');
            
            // Valor final calculado (el subtotal del ítem)
            $table->decimal('costo_final', 10, 2); 
            $table->boolean('requiere_diseno')->default(false); // Si se marcó la opción de diseño

            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_carrito');
    }
};