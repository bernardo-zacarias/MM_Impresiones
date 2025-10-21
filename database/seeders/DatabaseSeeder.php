<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class, // <-- Añadimos nuestro nuevo Seeder de Usuarios
            // Aquí podrías añadir CategoriaSeeder::class, ProductoSeeder::class, etc.
        ]);
    }
}
