<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $restaurants = Restaurant::with('user')->get();
        $items = Item::with('restaurant')->get();

        return Inertia::render('Home/Index', [
            'restaurants' => $restaurants,
            'items' => $items,
        ]);
    }
}
