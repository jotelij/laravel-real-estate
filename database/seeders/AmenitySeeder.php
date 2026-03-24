<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amenities = [
            'Swimming Pool',
            'Gym',
            'Garden',
            'Garage',
            'Fireplace',
            'Air Conditioning',
            'Balcony',
            'Security System',
            'Elevator',
            'Wheelchair Access',
        ];

        foreach ($amenities as $amenity) {
            \App\Models\Amenity::factory()->create(['name' => $amenity]);
        }
    }
}
