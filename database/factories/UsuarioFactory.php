<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre'=> $this->faker->name(),
            'apellido'=> $this->faker->firstName(),
            'email'=> $this->faker->email(),
            'telefono'=> $this->faker->numberBetween(60000000, 79999999),
            'username'=> $this->faker->userName(),
            'password'=> $this->faker->password(),
            'cargo_id'=> $this->faker->numberBetween(1, 10) 
        ];
    }
}
