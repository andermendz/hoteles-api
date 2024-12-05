<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use Illuminate\Http\JsonResponse;

class AccommodationController extends Controller
{
    public function index(): JsonResponse
    {
        $accommodations = Accommodation::all();
        return response()->json($accommodations);
    }
}
