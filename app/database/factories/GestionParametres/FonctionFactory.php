<?php

namespace Database\Factories\GestionParametres;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GestionParametres\Fonction>
 */
class FonctionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->text(7),
            'description' => $this->faker->text(22),
        ];
    }
}
