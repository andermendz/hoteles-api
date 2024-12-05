<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => 'Decameron ' . $this->faker->unique()->city(),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'nit' => $this->faker->unique()->numerify('#########-#'),
            'total_rooms' => $this->faker->numberBetween(30, 200),
        ];
    }
}