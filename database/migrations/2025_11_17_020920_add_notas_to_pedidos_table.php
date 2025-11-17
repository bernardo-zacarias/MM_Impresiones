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
        Schema::table('pedidos', function (Blueprint $table) {
            // Notas o comentarios del cliente sobre el pedido
            $table->text('notas_cliente')->nullable()->after('total');
            
            // Notas internas del administrador (no visibles para el cliente)
            $table->text('notas_admin')->nullable()->after('notas_cliente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn(['notas_cliente', 'notas_admin']);
        });
    }
};
