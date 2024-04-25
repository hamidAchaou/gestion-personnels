<?php

namespace Database\Factories\GestionPersonnels;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GestionPersonnels\Specialite>
 */
class SpecialiteFactory extends Factory
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
