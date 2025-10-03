<?php

namespace Database\Seeders;

use App\Models\Activo;
use App\Models\Cargo;
use App\Models\Tarea;
use App\Models\User;
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
        Cargo::factory(10)->create();
        // Usuario::factory(20)->create();
        User::factory(20)->create();
        Activo::factory(50)->create();
        Tarea::factory(20)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
