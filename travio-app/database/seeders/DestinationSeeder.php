<?php
// database/seeders/DestinationSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\DestinationType;
use App\Models\Destination;

class DestinationSeeder extends Seeder
{
    public function run(): void
    {
        // Берём все города и все типы
        $cities = City::all();
        $types  = DestinationType::all();

        foreach ($cities as $city) {
            foreach ($types as $type) {
                Destination::create([
                    'city_id'              => $city->id,
                    'destination_type_id'  => $type->id,
                    'description'          => "Explore the {$type->name} experience in {$city->name}.",
                ]);
            }
        }
    }
}

