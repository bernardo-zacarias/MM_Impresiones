<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User; // <-- 1. IMPORTANTE: Añadimos el modelo User

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
        // Credenciales: admin@iluminar.com / password
        // 2. IMPORTANTE: Usamos exists() para no duplicar si el seeder se ejecuta varias veces
        if (!User::where('email', 'admin@iluminar.com')->exists()) {
            DB::table('users')->insert([
                'name' => 'Admin Usuario',
                'email' => 'admin@iluminar.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Contraseña: password
                'rol' => 'admin', // Mantenemos tu columna 'rol'
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Usuario Cliente (Acceso a /home)
        // Credenciales: cliente@iluminar.com / password
        if (!User::where('email', 'cliente@iluminar.com')->exists()) {
            DB::table('users')->insert([
                'name' => 'Cliente Usuario',
                'email' => 'cliente@iluminar.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Contraseña: password
                'rol' => 'client', // Mantenemos tu columna 'rol'
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
