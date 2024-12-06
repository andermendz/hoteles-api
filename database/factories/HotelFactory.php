<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    public function definition()
    {
        return [
            'name' =>  $this->faker->unique()->city() .' '. $this->faker->city(),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'nit' => $this->faker->unique()->numerify('#########-#'),
            // declarar el rango aleatorio de numero de habitaciones a preferencia
            'total_rooms' => $this->faker->numberBetween(20, 100),
        ];
    }
}