<?php

namespace Database\Seeders;

use App\Models\Activo;
use App\Models\Cargo;
use App\Models\Repuesto;
use App\Models\Tarea;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Repuesto::factory(10)->create();
        // User::factory(10)->create();
        // Cargo::factory(10)->create();
        // Usuario::factory(20)->create();
        // User::factory(20)->create();
        // Activo::factory(50)->create();
        // Tarea::factory(20)->create();

        // Crear permisos
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        
        Permission::create(['name' => 'view posts']);
        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'edit posts']);
        Permission::create(['name' => 'delete posts']);

        // Crear roles y asignar permisos
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $administradorRole = Role::create(['name' => 'administrador']);
        $administradorRole->givePermissionTo(Permission::all());

        $editorRole = Role::create(['name' => 'editor']);
        $editorRole->givePermissionTo(['view posts', 'create posts', 'edit posts']);

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo(['view posts']);

        // Crear cargo de desarrollador
        $cargoDesarrollador = \App\Models\Cargo::create([
            'descripcion' => 'Desarrollador',
            'area' => 'Sistemas'
        ]);

        // craer usuarios admin
        $usuarioAdmin = User::factory()->create([
            'nombre' => 'Cristian',
            'apellido' => 'Flores',
            'email' => 'humbertflores57@gmail.com',
            'username' => 'cflores',
            'password' => bcrypt('cflores'),
            'telefono' => '67120162',
        ]);
        $usuarioAdmin->assignRole([$administradorRole]);

        // Crear designación como desarrollador
        \App\Models\Designacion::create([
            'estado' => 'activo',
            'usuario_id' => $usuarioAdmin->id,
            'cargo_id' => $cargoDesarrollador->id,
            'fecha_inicio' => now(),
            'fecha_fin' => null
        ]);

        
    }
}
