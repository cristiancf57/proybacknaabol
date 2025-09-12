<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reporte>
 */
class ReporteFactory extends Factory
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
            // 'foto'=> $this->faker->randomElement(['camara.jpg','cpudell.jpg','dell.jpg','impresora.jpg','lexmark.jpg','lg.jpg','monitor.jpg','scanner.webp','teclast.jpg']),
            'fecha' => $this->faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
            'hora'  => $this->faker->dateTimeBetween('-1 years', 'now')->format('H:i:s'),
            'estado'=> $this->faker->randomElement(['nuevo','culminado']),
            'personal'=> $this->faker->name()
        ];
    }
}
