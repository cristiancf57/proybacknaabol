<?php

namespace Database\Seeders;

use App\Models\Activo;
use App\Models\Reporte;
use App\Models\Rol;
use App\Models\Tipo;
use App\Models\User;
use App\Models\Usuario;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Rol::factory(10)->create();
        Usuario::factory(20)->create();
        Tipo::factory(10)->create();
        Activo::factory(50)->create();
        Reporte::factory(20)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
