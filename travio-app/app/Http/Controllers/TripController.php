<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function confirm(Request $request)
    {
        // Получаем массив мест из запроса
        $items = json_decode($request->input('items'), true);
        $emails = json_decode($request->input('participants'), true);

        // Создаём новый Trip для текущего пользователя
        $trip = Trip::create([
            'user_id' => auth()->id,
            'total' => 0, // сумму посчитаем ниже
            'start_date' => $items[0]['check_in'], // например, дата начала первого места
            'end_date' => end($items)['check_out'], // дата окончания последнего
        ]);

        $totalPrice = 0;
        // Перебираем добавленные места и связываем их с Trip
        foreach ($items as $item) {
            // Рассчитываем стоимость: цена * длительность (дней) * гостей
            $pricePerNight = $item['price'];
            $nights = (new \DateTime($item['check_in']))->diff(new \DateTime($item['check_out']))->days;
            $itemTotal = $pricePerNight * $nights * $item['guests'];
            $totalPrice += $itemTotal;

            // Связываем через pivot-таблицу (TripPlace) с дополнительными полями
            $trip->places()->attach($item['id'], [
                'check_in' => $item['check_in'],
                'check_out' => $item['check_out'],
                'guests' => $item['guests'],
                'price_per_night' => $pricePerNight,
                'total_price' => $itemTotal,
            ]);
        }

        // Записываем общую стоимость Trip
        $trip->update(['total' => $totalPrice]);

        // Добавляем дополнительных участников (по email)
        foreach ($emails as $email) {
            if ($email) {
                $trip->participants()->create(['email' => $email]);
            }
        }

        // Возвращаем успешный ответ (JSON)
        return response()->json(['success' => true, 'trip_id' => $trip->id]);
    }
}
