<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\AccommodationController;


Route::get('/', function () {
    return view('welcome');
});

