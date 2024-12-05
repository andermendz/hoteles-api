<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelRoom;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HotelController extends Controller
{
    public function index(): JsonResponse
    {
        $hotels = Hotel::with('hotelRooms.roomType', 'hotelRooms.accommodation')->get();
        return response()->json($hotels);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|unique:hotels',
            'address' => 'required',
            'city' => 'required',
            'nit' => 'required|unique:hotels',
            'total_rooms' => 'required|integer|min:1',
            'rooms' => 'required|array'
        ]);

        $hotel = Hotel::create($validated);

        foreach ($request->rooms as $room) {
            HotelRoom::create([
                'hotel_id' => $hotel->id,
                'room_type_id' => $room['room_type_id'],
                'accommodation_id' => $room['accommodation_id'],
                'quantity' => $room['quantity']
            ]);
        }

        return response()->json($hotel, 201);
    }
}
