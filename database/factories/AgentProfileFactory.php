<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AgentProfile>
 */
class AgentProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'agency_name' => fake()->name(),
            'license_number' => fake()->unique()->numerify('####'),
            'bio' => fake()->paragraph(),
            'est' => fake()->date(),
            'is_approved' => false,
            'average_rating' => 0,
        ];
    }
}
