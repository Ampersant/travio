<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountryCitySeeder::class,
            AmenitySeeder::class,
            DestinationTypeSeeder::class,
            DestinationSeeder::class,
            PlaceSeeder::class,
            AmenityPlaceSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
