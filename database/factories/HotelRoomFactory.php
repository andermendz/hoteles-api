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
            'hotel_id' => Hotel::factory(),
            'room_type_id' => RoomType::factory(),
            'accommodation_id' => Accommodation::factory(),
            'quantity' => $this->faker->numberBetween(5, 50),
        ];
    }
}