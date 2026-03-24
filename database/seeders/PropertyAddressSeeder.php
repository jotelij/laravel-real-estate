<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertyAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Property::all()->each(function ($property) {
            $property->address()->create([
                'address_line_1' => fake()->streetAddress(),
                'address_line_2' => fake()->secondaryAddress(),
                'city' => fake()->city(),
                'region' => fake()->stateAbbr(),
                'postcode' => fake()->postcode(),
                'country' => fake()->country(),
                'latitude' => fake()->latitude(),
                'longitude' => fake()->longitude(),
            ]);
        });
    }
}
