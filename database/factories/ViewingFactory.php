<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Viewing>
 */
class ViewingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'scheduled_at' => $this->faker->dateTimeBetween('+1 day', '+2 weeks'),
            'status' => $this->faker->randomElement(\App\Enums\ViewingsStatus::cases()),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
