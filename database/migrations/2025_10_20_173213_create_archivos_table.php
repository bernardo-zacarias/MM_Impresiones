<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archivos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_original');
            $table->string('ruta'); // La ruta donde se guarda el archivo en el sistema de archivos
            $table->string('mime_type')->nullable(); // Tipo de archivo (ej: image/jpeg)

            // Claves foráneas opcionales (un archivo puede adjuntarse a una cotización O a un pedido)
            $table->foreignId('cotizacion_id')->nullable()->constrained('cotizaciones')->onDelete('cascade');
            $table->foreignId('pedido_id')->nullable()->constrained('pedidos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archivos');
    }
};
