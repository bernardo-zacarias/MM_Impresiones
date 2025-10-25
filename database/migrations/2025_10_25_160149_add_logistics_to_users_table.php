<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telefono', 15)->after('email')->nullable(); // Teléfono (lo haremos obligatorio en la vista)
            $table->string('comuna')->after('telefono')->nullable(); // Comuna
            $table->string('ciudad')->after('comuna')->nullable(); // Ciudad
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['telefono', 'comuna', 'ciudad']);
        });
    }
};