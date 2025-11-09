<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'admin@mmimpresiones.com')->exists()) {
            User::create([
                'name' => 'Administrador Principal',
                'email' => 'admin@mmimpresiones.com',
                'password' => Hash::make('Admin1234'), 
                'rol' => 'admin',
                'telefono' => '987654321', 
                'comuna' => 'Santiago',
                'ciudad' => 'Región Metropolitana',
            ]);
        }
    }
}