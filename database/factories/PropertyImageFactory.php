<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PropertyImage>
 */
class PropertyImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image_path' => $this->faker->imageUrl(800, 600, 'real-estate', true),
            'is_primary' => $this->faker->boolean(20), // 20%
            'sort_order' => $this->faker->numberBetween(1, 10),
        ];
    }
}
