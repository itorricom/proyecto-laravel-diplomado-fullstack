<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Usuario::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'nombre' => 'Administrador',
            'estado' => 'A',
            'ultimo_acceso' => now(),
        ]);

        Usuario::create([
            'username' => 'usuario1',
            'email' => 'usuario1@example.com',
            'password' => Hash::make('password123'),
            'nombre' => 'Juan Pérez',
            'estado' => 'A',
            'ultimo_acceso' => now(),
        ]);

        Usuario::create([
            'username' => 'usuario2',
            'email' => 'usuario2@example.com',
            'password' => Hash::make('password123'),
            'nombre' => 'María García',
            'estado' => 'A',
            'ultimo_acceso' => now(),
        ]);
    }
}
