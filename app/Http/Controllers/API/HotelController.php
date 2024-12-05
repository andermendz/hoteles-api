<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Http\Requests\StoreHotelRequest;
use App\Http\Requests\UpdateHotelRequest;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Hotel::with('hotelRooms.roomType', 'hotelRooms.accommodation')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHotelRequest $request, Hotel $hotel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        //
    }
}
