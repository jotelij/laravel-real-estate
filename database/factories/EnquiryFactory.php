<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enquiry>
 */
class EnquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'property_id' => \App\Models\AgentProfile::factory(),
            'subject' => $this->faker->sentence(),
            'message' => $this->faker->paragraphs(1, true),
            'status' => $this->faker->randomElement(\App\Enums\EnquiryStatus::cases()),
        ];
    }
}
