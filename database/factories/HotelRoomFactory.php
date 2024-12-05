<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\Accommodation;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelRoomFactory extends Factory
{
    public function definition()
    {
       
        return [
            'room_type_id' => RoomType::factory(),
            'accommodation_id' => Accommodation::factory(),
            'quantity' => function (array $attributes) {
                // La cantidad se calcula basada en el hotel al que se asigne
                $hotel = Hotel::find($attributes['hotel_id']);
                return min($this->faker->numberBetween(5, 20), $hotel->total_rooms);
            },
        ];
    }
}
