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
        // crear tipos de habitación fijos
        $roomTypes = [
            'ESTANDAR' => RoomType::create(['name' => 'ESTANDAR']),
            'JUNIOR' => RoomType::create(['name' => 'JUNIOR']),
            'SUITE' => RoomType::create(['name' => 'SUITE'])
        ];

        // crear acomodaciones fijas
        $accommodations = [
            'SENCILLA' => Accommodation::create(['name' => 'SENCILLA']),
            'DOBLE' => Accommodation::create(['name' => 'DOBLE']),
            'TRIPLE' => Accommodation::create(['name' => 'TRIPLE']),
            'CUÁDRUPLE' => Accommodation::create(['name' => 'CUÁDRUPLE'])
        ];

        // crear hoteles con habitaciones controladas
        Hotel::factory(5)->create()->each(function ($hotel) use ($roomTypes, $accommodations) {
            $remainingRooms = $hotel->total_rooms;
            
            // distribuir las habitaciones proporcionalmente
            $distributions = [
                ['type' => 'ESTANDAR', 'acc' => 'SENCILLA', 'percentage' => 0.5],
                ['type' => 'JUNIOR', 'acc' => 'TRIPLE', 'percentage' => 0.3],
                ['type' => 'SUITE', 'acc' => 'DOBLE', 'percentage' => 0.2],
            ];

            foreach ($distributions as $dist) {
                $quantity = (int)($hotel->total_rooms * $dist['percentage']);
                if ($quantity > 0) {
                    HotelRoom::create([
                        'hotel_id' => $hotel->id,
                        'room_type_id' => $roomTypes[$dist['type']]->id,
                        'accommodation_id' => $accommodations[$dist['acc']]->id,
                        'quantity' => $quantity
                    ]);
                    $remainingRooms -= $quantity;
                }
            }

            // si quedan habitaciones, añadirlas a la primera configuración
            if ($remainingRooms > 0) {
                HotelRoom::where('hotel_id', $hotel->id)
                    ->first()
                    ->increment('quantity', $remainingRooms);
            }
        });
    }
}
