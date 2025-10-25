<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items_carrito', function (Blueprint $table) {
            // Hacemos que cotizacion_id sea nullable (si no lo es ya)
            $table->foreignId('cotizacion_id')->nullable()->change(); 
            
            // Añadimos el nuevo ID para el Catálogo
            $table->foreignId('producto_id')->nullable()->constrained('productos')->after('cotizacion_id');
        });
    }

    public function down(): void
    {
        Schema::table('items_carrito', function (Blueprint $table) {
            $table->dropForeign(['producto_id']);
            $table->dropColumn('producto_id');
            // Revertir cotizacion_id a no nullable si era requerido originalmente
            // $table->foreignId('cotizacion_id')->nullable(false)->change(); 
        });
    }
};