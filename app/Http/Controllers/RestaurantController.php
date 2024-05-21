<?php

namespace App\Http\Controllers;

use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            $restaurants = Restaurant::with('items')->get();
            return response()->json([
                'data' => $restaurants,
            ]);       
        }
    }

    public function get(Request $request, $id)
    {
        if ($request->expectsJson()) {
            $restaurant = Restaurant::with('items')->findOrFail($id);
            // give up pakai ni
            // return RestaurantResource::collection($restaurant);

            return response()->json([
                'data' => $restaurant,
            ]);        
        }
    }
}
