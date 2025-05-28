<?php

// database/seeders/AmenitySeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Amenity;

class AmenitySeeder extends Seeder
{
    public function run(): void
    {
        $amenities = [
            'Swimming Pool',
            'Free WiFi',
            'Breakfast Included',
            'Free Parking',
            'Spa Service',
        ];

        foreach ($amenities as $name) {
            Amenity::create(['name' => $name]);
        }
    }
}

