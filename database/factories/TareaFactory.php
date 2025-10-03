<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reporte>
 */
class TareaFactory extends Factory
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
            'tipo_reporte'=> $this->faker->randomElement(['electronica','cns','sistemas']),
            'fecha' => $this->faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
            'hora'  => $this->faker->dateTimeBetween('-1 years', 'now')->format('H:i:s'),
            'estado'=> $this->faker->randomElement(['nuevo','culminado']),
            'personal'=> $this->faker->name()
        ];
    }
}
