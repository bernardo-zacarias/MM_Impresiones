<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items_pedido', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
            
            // Relaciones
            $table->foreignId('cotizacion_id')->nullable()->constrained('cotizaciones')->onDelete('set null');
            $table->foreignId('producto_id')->nullable()->constrained('productos')->onDelete('set null');
            
            // Datos del Ítem
            $table->integer('cantidad');
            $table->decimal('costo_final', 10, 2); 
            $table->float('ancho')->nullable();
            $table->float('alto')->nullable();
            $table->boolean('requiere_diseno')->default(false);
            $table->string('ruta_archivo')->nullable(); // Ruta del archivo subido
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items_pedido');
    }
};