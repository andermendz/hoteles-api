<?php

namespace Database\Seeders;

use App\Models\RoomType;
use App\Models\Accommodation;
use App\Models\Hotel;
use App\Models\HotelRoom;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Crear tipos de habitación fijos
        $roomTypes = [
            'ESTANDAR' => RoomType::create(['name' => 'ESTANDAR']),
            'JUNIOR' => RoomType::create(['name' => 'JUNIOR']),
            'SUITE' => RoomType::create(['name' => 'SUITE'])
        ];

        // Crear acomodaciones fijas
        $accommodations = [
            'SENCILLA' => Accommodation::create(['name' => 'SENCILLA']),
            'DOBLE' => Accommodation::create(['name' => 'DOBLE']),
            'TRIPLE' => Accommodation::create(['name' => 'TRIPLE']),
            'CUÁDRUPLE' => Accommodation::create(['name' => 'CUÁDRUPLE'])
        ];

        // Crear X hoteles con sus habitaciones
        Hotel::factory(5)->create()->each(function ($hotel) use ($roomTypes, $accommodations) {
            // Agregar habitaciones respetando las reglas de negocio
            HotelRoom::create([
                'hotel_id' => $hotel->id,
                'room_type_id' => $roomTypes['ESTANDAR']->id,
                'accommodation_id' => $accommodations['SENCILLA']->id,
                'quantity' => rand(10, 30)
            ]);

            HotelRoom::create([
                'hotel_id' => $hotel->id,
                'room_type_id' => $roomTypes['JUNIOR']->id,
                'accommodation_id' => $accommodations['TRIPLE']->id,
                'quantity' => rand(5, 15)
            ]);

            HotelRoom::create([
                'hotel_id' => $hotel->id,
                'room_type_id' => $roomTypes['SUITE']->id,
                'accommodation_id' => $accommodations['DOBLE']->id,
                'quantity' => rand(3, 10)
            ]);
        });
    }
}
