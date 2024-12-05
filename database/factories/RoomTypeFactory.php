<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomTypeFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['ESTANDAR', 'JUNIOR', 'SUITE'])
        ];
    }
}