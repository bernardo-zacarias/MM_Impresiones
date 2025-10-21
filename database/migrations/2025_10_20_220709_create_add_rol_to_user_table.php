<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones (Run the migrations).
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Añade una columna 'rol' que será una cadena (string) de 50 caracteres
            // con un valor por defecto de 'cliente', después de la columna 'email'.
            $table->string('rol', 50)->default('cliente')->after('email'); 
        });
    }

    /**
     * Revierte las migraciones (Reverse the migrations).
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cuando se revierta la migración, elimina la columna 'rol'.
            $table->dropColumn('rol');
        });
    }
};
