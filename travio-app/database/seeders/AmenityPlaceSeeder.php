<?php
// database/seeders/AmenityPlaceSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Place;
use App\Models\Amenity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class AmenityPlaceSeeder extends Seeder
{
    public function run(): void
    {
        // Получаем все ID удобств
        $amenityIds = Amenity::pluck('id')->toArray();

        Place::all()->each(function ($place) use ($amenityIds) {
            // Для каждого места случайно выбираем от 1 до всех доступных удобств
            $assigned = Arr::random(
                $amenityIds,
                rand(1, count($amenityIds))
            );

            // Если выбрано одно значение, приводим к массиву
            $assigned = is_array($assigned) ? $assigned : [$assigned];

            // Вставляем в pivot-таблицу
            foreach ($assigned as $amenityId) {
                DB::table('amenity_place')->insert([
                    'place_id'   => $place->id,
                    'amenity_id' => $amenityId,
                ]);
            }
        });
    }
}
