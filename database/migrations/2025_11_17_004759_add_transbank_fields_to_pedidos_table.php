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
            // Token único de la transacción Transbank
            $table->string('transbank_token')->nullable()->after('metodo_pago');
            
            // Código de autorización de la transacción
            $table->string('transbank_authorization_code')->nullable()->after('transbank_token');
            
            // Orden de compra (buy_order)
            $table->string('transbank_buy_order')->nullable()->after('transbank_authorization_code');
            
            // Tipo de pago (VD = Débito, VN = Crédito, etc.)
            $table->string('transbank_payment_type_code', 10)->nullable()->after('transbank_buy_order');
            
            // Monto pagado (puede diferir del total si hay descuentos)
            $table->decimal('transbank_amount', 10, 2)->nullable()->after('transbank_payment_type_code');
            
            // Fecha de transacción
            $table->timestamp('transbank_transaction_date')->nullable()->after('transbank_amount');
            
            // Respuesta completa de Transbank (JSON para debugging)
            $table->json('transbank_response')->nullable()->after('transbank_transaction_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn([
                'transbank_token',
                'transbank_authorization_code',
                'transbank_buy_order',
                'transbank_payment_type_code',
                'transbank_amount',
                'transbank_transaction_date',
                'transbank_response'
            ]);
        });
    }
};
