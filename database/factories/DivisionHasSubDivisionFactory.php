<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubDivision>
 */
class DivisionHasSubDivisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'division_id' => fake()->numberBetween(1, 5),
            'sub_division_id' => fake()->unique()->numberBetween(6, 28),
        ];
    }
}
