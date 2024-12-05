<?php

use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\RoomTypeController;
use App\Http\Controllers\Api\AccommodationController;
use Illuminate\Support\Facades\Route;

Route::apiResource('hotels', HotelController::class);
Route::apiResource('room-types', RoomTypeController::class)->only(['index']);
Route::apiResource('accommodations', AccommodationController::class)->only(['index']);
