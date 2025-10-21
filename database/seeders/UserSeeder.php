<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Usuario Administrador (Acceso a /administracion)
        DB::table('users')->insert([
            'name' => 'Admin Usuario',
            'email' => 'admin@iluminar.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Contraseña: password
            'rol' => 'admin', // Rol especial para acceder a las rutas protegidas
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Usuario Cliente (Acceso a /home)
        DB::table('users')->insert([
            'name' => 'Cliente Usuario',
            'email' => 'cliente@iluminar.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Contraseña: password
            'rol' => 'client', // Rol estándar
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Opcional: Crear 10 usuarios adicionales (faker) si tienes instalado Laravel Factory
        // \App\Models\User::factory(10)->create();
    }
}
