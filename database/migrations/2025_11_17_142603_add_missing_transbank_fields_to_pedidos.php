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
            // Eliminar columna incorrecta si existe
            if (Schema::hasColumn('pedidos', 'transbank_response_code')) {
                $table->dropColumn('transbank_response_code');
            }
            
            // Agregar columnas faltantes
            if (!Schema::hasColumn('pedidos', 'transbank_transaction_date')) {
                $table->timestamp('transbank_transaction_date')->nullable()->after('transbank_amount');
            }
            
            if (!Schema::hasColumn('pedidos', 'transbank_response')) {
                $table->json('transbank_response')->nullable()->after('transbank_transaction_date');
            }
            
            if (!Schema::hasColumn('pedidos', 'notas_cliente')) {
                $table->text('notas_cliente')->nullable()->after('notas');
            }
            
            if (!Schema::hasColumn('pedidos', 'notas_admin')) {
                $table->text('notas_admin')->nullable()->after('notas_cliente');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn([
                'transbank_transaction_date',
                'transbank_response',
                'notas_cliente',
                'notas_admin'
            ]);
        });
    }
};
