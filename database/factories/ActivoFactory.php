<?php

namespace Database\Factories;

use Faker\Guesser\Name;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activo>
 */
class ActivoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'detalle'=> $this->faker->text(50),
            'codigo'=> $this->faker->numberBetween(20000000, 99999999),
            'marca'=> $this->faker->words(2, true),
            'modelo'=> $this->faker->text(15),
            'serie'=> $this->faker->numberBetween(100, 10000),
            'color'=> $this->faker->randomElement(['Azul oscuro','negro','plomo plata','plomo oscuro']),
            'area'=> $this->faker->randomElement(['sistemas','administrativa','financiera','mantenimiento','electronica','jefatura','coe','cns']),
            'ip' => $this->faker->ipv4,
            'ubicacion'=> $this->faker->text(15),
            'estado'=> $this->faker->randomElement(['Operable','Reparacion','Baja']),
            'fecha' => $this->faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'descripcion'=> $this->faker->text(30),
            'tipo_id'=> $this->faker->numberBetween(1,10)
        ];
    }
}
