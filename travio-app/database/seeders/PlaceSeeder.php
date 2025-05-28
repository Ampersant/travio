<?php
// database/seeders/PlaceSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destination;
use App\Models\Place;
use Faker\Factory as Faker;

class PlaceSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        
        $images = [
            'img-1.jpg',
            'img-2.jpg',
            'img-3.jpg',
            'img-4.jpg',
            'img-5.jpg',
            'img-6.jpg',
            'img-7.jpg',        
        ];
        Destination::all()->each(function ($dest) use ($faker, $images) {
            for ($i = 1; $i <= 3; $i++) {
                Place::create([
                    'destination_id' => $dest->id,
                    'name'           => ucfirst($faker->unique()->words(2, true)),
                    'price'          => $faker->randomFloat(2, 30, 300),
                    'rating'         => $faker->randomElement([1.0, 1.5, 2.0, 2.5, 3.0, 3.5, 4.0, 4.5, 5.0]),
                    'description'    => $faker->sentence(12),
                    'image_url'      => $faker->randomElement($images),
                ]);
            }
        });
    }
}
