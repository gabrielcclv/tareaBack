<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->unique()->randomNumber(),
            'nombre' => fake()->name(),
            'apellido' => fake()->lastName(),
            'edad' => fake()->numberBetween(20, 60),
            'rol' => function (array $attributes) {
                return $attributes['edad'] > 40 ? 2 : 1;
            },
        ];
    }

}
