<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Repuesto>
 */
class RepuestoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre'=> $this->faker->word(),
            'marca'=> $this->faker->words(2, true),
            'modelo'=> $this->faker->text(15),
            'descripcion'=> $this->faker->text(50),
            'stock'=> $this->faker->numberBetween(1, 15)
        ];
    }
}
