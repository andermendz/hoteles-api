<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\AccommodationController;


    Route::get('/hotels', [HotelController::class, 'index']);
    Route::post('/hotels', [HotelController::class, 'store']);
    Route::get('/room-types', [RoomTypeController::class, 'index']);
    Route::get('/accommodations', [AccommodationController::class, 'index']);

    Route::delete('/hotels/{hotel}', [HotelController::class, 'destroy']);
