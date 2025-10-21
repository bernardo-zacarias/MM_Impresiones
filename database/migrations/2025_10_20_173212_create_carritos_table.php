<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carritos', function (Blueprint $table) {
            $table->id();
            // foreignId('usuario_id') y constrained('users') para el usuario que posee el carrito.
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->string('estado')->default('activo'); // Puede ser 'activo' o 'comprado'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carritos');
    }
};
