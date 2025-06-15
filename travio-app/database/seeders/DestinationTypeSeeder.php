<?php

// database/seeders/DestinationTypeSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DestinationType;

class DestinationTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Beach',
            'Mountain',
            'City',
        ];

        foreach ($types as $name) {
            DestinationType::create(['name' => $name]);
        }
    }
}

