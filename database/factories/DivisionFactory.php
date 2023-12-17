<?php

namespace Database\Factories;

use App\Models\Division;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Division>
 */
class DivisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Division::class;

    public function definition(): array
    {
        $name = fake()->optional()->firstNameMale();
        $lastName = fake()->optional()->lastName();
        return [
            'name' => fake()->unique()->name(),
            'division_superior_id' => fake()->numberBetween(0, 3) === 0 ? null : Division::inRandomOrder()->first(),
            'level' => fake()->randomNumber(2),
            'ambassador_name' => $name ? $name . ' ' . $lastName : null
        ];
    }
}
