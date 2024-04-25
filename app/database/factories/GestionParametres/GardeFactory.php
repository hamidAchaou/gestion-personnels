<?php

namespace Database\Factories\GestionPersonnels;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class GardeFactory extends Factory
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
            'echell_debut' => $this->faker->date(),
            'echell_fin' => $this->faker->date(),
        ];
    }
}
