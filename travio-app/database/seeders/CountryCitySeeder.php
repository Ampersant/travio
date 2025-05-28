<?php

// database/seeders/CountryCitySeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\City;

class CountryCitySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            "france" => ["paris", "nice", "lyon", "marseille"],
            "italy" => ["rome", "venice", "florence", "milan"],
            "spain" => ["barcelona", "madrid", "seville", "valencia"],
            "greece" => ["santorini", "athens", "mykonos", "rhodes"],
            "japan" => ["kyoto", "tokyo", "osaka", "sapporo"],
            "usa" => ["new-york", "los-angeles", "chicago", "miami"],
            "thailand" => ["phuket", "bangkok", "chiang-mai", "krabi"],
            "switzerland" => ["zermatt", "zurich", "geneva", "interlaken"],
        ];

        foreach ($data as $countryName => $cities) {
            $country = Country::create([
                'name' => ucfirst($countryName),
            ]);

            foreach ($cities as $cityName) {
                City::create([
                    'name' => ucfirst(str_replace('-', ' ', $cityName)),
                    'country_id' => $country->id,
                ]);
            }
        }
    }
}

