<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items_carrito', function (Blueprint $table) {
            // Columna para guardar la ruta pública del archivo (ej: 'disenos_clientes/nombre_archivo.pdf')
            $table->string('ruta_archivo')->nullable()->after('requiere_diseno');
        });
    }

    public function down(): void
    {
        Schema::table('items_carrito', function (Blueprint $table) {
            $table->dropColumn('ruta_archivo');
        });
    }
};