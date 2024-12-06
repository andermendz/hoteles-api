<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelRoom;
use App\Http\Requests\StoreHotelRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller
{
    public function index(): JsonResponse
    {
        $hotels = Hotel::with('hotelRooms.roomType', 'hotelRooms.accommodation')->get();
        return response()->json($hotels);
    }

    public function store(StoreHotelRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            // validar que la suma total de habitaciones coincida
            $totalRoomsRequested = collect($request->rooms)->sum('quantity');
            if ($totalRoomsRequested != $request->total_rooms) {
                return response()->json([
                    'message' => 'La suma de habitaciones no coincide con el total especificado'
                ], 422);
            }

            // crear el hotel
            $hotel = Hotel::create($request->validated());

            // verificar combinaciones únicas de tipo-acomodación
            $combinations = collect($request->rooms)
                ->map(fn($room) => "{$room['room_type_id']}-{$room['accommodation_id']}")
                ->duplicates();

            if ($combinations->isNotEmpty()) {
                return response()->json([
                    'message' => 'No se permiten combinaciones duplicadas de tipo y acomodación'
                ], 422);
            }

            // crear las habitaciones
            foreach ($request->rooms as $room) {
                HotelRoom::create([
                    'hotel_id' => $hotel->id,
                    'room_type_id' => $room['room_type_id'],
                    'accommodation_id' => $room['accommodation_id'],
                    'quantity' => $room['quantity']
                ]);
            }

            DB::commit();
            return response()->json($hotel->load('hotelRooms.roomType', 'hotelRooms.accommodation'), 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al crear el hotel'], 500);
        }
    }


    public function destroy(Hotel $hotel): JsonResponse
    {
        try {
            
            $hotel->delete();
            
            return response()->json([
                'message' => 'Hotel eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el hotel'
            ], 500);
        }
    }
    

}
