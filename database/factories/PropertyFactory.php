<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'agent_id' => \App\Models\AgentProfile::factory(),
            'title' => $this->faker->sentence(6),
            'slug' => $this->faker->unique->slug(),
            'description' => $this->faker->paragraphs(3, true),
            'property_type' => $this->faker->randomElement(\App\Enums\PropertyType::cases()),
            'listing_type' => $this->faker->randomElement(\App\Enums\ListingType::cases()),
            'status' => $this->faker->randomElement(\App\Enums\PropertyStatus::cases()),
            'price' => $this->faker->numberBetween(50000, 1000000),
            'bedrooms' => $this->faker->numberBetween(1, 5),
            'bathrooms' => $this->faker->numberBetween(1, 4),
            'garages' => $this->faker->numberBetween(0, 3),
            'floor_area' => $this->faker->numberBetween(500, 5000),
            'land_area' => $this->faker->numberBetween(1000, 10000),
            'year_built' => $this->faker->year(),
            'is_featured' => $this->faker->boolean(20), // 20% chance to be featured
            'views_count' => $this->faker->numberBetween(0, 1000),
            'virtual_tour_link' => $this->faker->optional()->url(),
        ];
    }
}
