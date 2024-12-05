<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{

    use HasFactory;
    
    protected $fillable = ['name', 'address', 'city', 'nit', 'total_rooms'];

    public function hotelRooms()
    {
        return $this->hasMany(HotelRoom::class);
    }
}