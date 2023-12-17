<?php

namespace Database\Factories;

use App\Models\Collaborator;
use App\Models\Division;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Collaborator>
 */
class CollaboratorFactory extends Factory
{

    protected $model = Collaborator::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fullname' => fake()->name() . ' ' . fake()->lastName(),
            'division_id' => Division::inRandomOrder()->first()
        ];
    }
}
