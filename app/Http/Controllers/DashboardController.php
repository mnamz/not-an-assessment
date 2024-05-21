<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {

        $orders = Order::where('restaurant_id', Auth::user()->restaurant?->id)
            ->whereDate('created_at', Carbon::today())
            ->with('restaurant')
            ->get();

        $total_orders = Order::where('restaurant_id', Auth::user()->restaurant?->id)
            ->count();

        $total_products = Item::where('restaurant_id', Auth::user()->restaurant?->id)
            ->count();

        $revenue = Order::where('restaurant_id', Auth::user()->restaurant?->id)
            ->with('restaurant')
            ->sum('total');

        return Inertia::render('Dashboard', [
            'orders_today' => $orders,
            'orders' => $total_orders,
            'products' => $total_products,
            'revenue' => $revenue,
        ]);
    }
}
