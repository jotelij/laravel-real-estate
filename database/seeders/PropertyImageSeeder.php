<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertyImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Property::all()->each(function ($property) {
            $property->images()->createMany([
                ['url' => 'https://placehold.co/800x600?text=Property+Image+1'],
                ['url' => 'https://placehold.co/800x600?text=Property+Image+2'],
                ['url' => 'https://placehold.co/800x600?text=Property+Image+3'],
                ['url' => 'https://placehold.co/800x600?text=Property+Image+4'],
            ]);
        });
    }
}
