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
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();

            // COLUMNAS QUE FALTABAN Y QUE EL CÓDIGO INTENTA INSERTAR:
            $table->string('nombre'); // <-- ¡AÑADIDA!
            $table->decimal('valor', 10, 2); // <-- ¡AÑADIDA! (Usamos decimal para valor monetario)
            $table->float('margen_porcentaje')->nullable(); // <-- ¡AÑADIDA!
            $table->date('fecha_validez')->nullable(); // <-- ¡AÑADIDA!
            $table->text('notas_cotizacion')->nullable(); // <-- ¡AÑADIDA!

            // Columna de usuario autenticado
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            
            // Columna opcional de producto (nullable)
            $table->foreignId('producto_id')->nullable()->constrained('productos')->onDelete('cascade'); 
            
            // Columnas que estaban anteriormente, ajustadas a nullable si no las envías en el formulario
            $table->float('ancho')->nullable(); 
            $table->float('alto')->nullable();  
            $table->integer('cantidad')->nullable(); 
            
            $table->string('estado')->default('pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizaciones');
    }
};
