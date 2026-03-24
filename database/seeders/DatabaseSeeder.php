<?php

namespace Database\Seeders;

use App\Enums\PropertyStatus;
use App\Enums\UserRole;
use App\Models\Amenity;
use App\Models\Property;
use App\Models\PropertyAddress;
use App\Models\PropertyImage;
use App\Models\User;
use Database\Factories\EnquiryFactory;
use Database\Factories\MessageFactory;
use Database\Factories\PropertyFactory;
use Database\Factories\ViewingFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            AmenitySeeder::class,
            CountrySeeder::class,
        ]);

        // assign work country
        $country = \App\Models\Country::where('code', 'US')->first();

       // create admin user
        $admin_user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => UserRole::ADMIN->value,
            'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
        ]);

        // create agent user
        $agent_user = User::factory()->create([
            'name' => 'Agent User',
            'email' => 'agent@example.com',
            'role' => UserRole::AGENT->value,
            'password' => Hash::make(env('AGENT_PASSWORD', 'password')),
        ]);

        $test_user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => UserRole::CUSTOMER->value,
            'password' => Hash::make(env('CUSTOMER_PASSWORD', 'password')),
        ]);


        // create 5 agents with profiles
        User::factory(5)->create(['role' => UserRole::AGENT->value])->each(function ($user, $index) {
            $user->agent_profile()->create([
                'agency_name' => fake()->company(),
                'license_number' => fake()->unique()->numerify('####'),
                'bio' => fake()->paragraph(),
                'est' => fake()->date(),
                'is_approved' => false,
                'average_rating' => 0,
            ])->each(function ($profile){
                $profile->properties()->createMany(
                    PropertyFactory::new()->count(10)->make()->toArray()
                );
            });
        });

        // also create some properties for the first agent
        $agent_user->agent_profile()->create([
            'agency_name' => fake()->company(),
            'license_number' => fake()->unique()->numerify('####'),
            'bio' => fake()->paragraph(),
            'est' => fake()->date(),
            'is_approved' => false,
            'average_rating' => 0,
        ])->each(function ($profile){
            $profile->properties()->createMany(
                PropertyFactory::new(['status' => PropertyStatus::ACTIVE])->count(10)->make()->toArray()
            );
            $profile->properties()->createMany(
                PropertyFactory::new()->count(15)->make()->toArray()
            );
        });
       
        
        foreach (Property::all() as $property) {
            $amenties = Amenity::all();

            // atach address
            $property->address()->create(
                PropertyAddress::factory()->makeOne(['country_id' => $country->id])->toArray()
            );
            
            // seed amenities for each property
            $property->amenities()->attach(
                $amenties->random(rand(3, 5))->pluck('id')->toArray()
            );

            // seed images for each property
            $property->images()->createMany(
                PropertyImage::factory()->count(3)->make()->toArray()
            );

            // seed address for each property
            $property->enquiries()->createMany(
                EnquiryFactory::new([
                    'agent_id' => $property->agent->user_id,
                    'sender_id' => User::where('role', UserRole::CUSTOMER)->inRandomOrder()->first()->id,
                ])->count(2)->make()->toArray()
            )->each(function ($enquiry) {
                // $agent_id = $enquiry
                // noew create message for each value
                $enquiry->messages()->createMany(
                    MessageFactory::new([
                        
                        'sender_id' => User::whereIn('id', [$enquiry->agent_id, $enquiry->sender_id])->get()->random()->id,
                    ])->count(2)->make()->toArray()
                ); 
            });
        }

        // seed on for test user
        $test_user->favourites()->attach(
            Property::where(['agent_id' => $agent_user->agent_profile->id])->get()->random(2)->pluck('id')->toArray()
        );

        $test_user->favourites()->attach(
            Property::all()->random(3)->pluck('id')->toArray()
        );

        $test_user->enquiries_sent()->createMany(
            EnquiryFactory::new([
                'agent_id' => Property::where(['agent_id' => $agent_user->agent_profile->id])->first()->agent->user_id,
                'property_id' => Property::where(['agent_id' => $agent_user->agent_profile->id])->first()->id,
            ])->count(3)->make()->toArray()
        )->each(function ($enquiry) {
            // $agent_id = $enquiry
            // noew create message for each value
            $enquiry->messages()->createMany(
                MessageFactory::new([
                    'sender_id' => User::whereIn('id', [$enquiry->agent_id, $enquiry->sender_id])->get()->random()->id,
                ])->count(3)->make()->toArray()
            ); 
        });

        $test_user->enquiries_sent()->createMany(
            EnquiryFactory::new([
                'agent_id' => Property::where(['agent_id' => $agent_user->agent_profile->id])->first()->agent->user_id,
                'property_id' => Property::where(['agent_id' => $agent_user->agent_profile->id])->first()->id,
            ])->count(3)->make()->toArray()
        )->each(function ($enquiry) {
            // $agent_id = $enquiry
            // noew create message for each value
            $enquiry->messages()->createMany(
                MessageFactory::new([
                    'sender_id' => User::whereIn('id', [$enquiry->agent_id, $enquiry->sender_id])->get()->random()->id,
                ])->count(3)->make()->toArray()
            ); 
        });

        $test_user->viewings()->createMany(
            ViewingFactory::new([
                'agent_id' => User::where(['id' => $agent_user->id])->first()->id,
                'property_id' => Property::where(['agent_id' => $agent_user->agent_profile->id])->first()->id,
            ])->count(3)->make()->toArray()
        );
    }
}
