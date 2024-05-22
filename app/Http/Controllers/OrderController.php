<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd(Auth::user()->restaurant->id);

        $total_orders = Order::where('restaurant_id', Auth::user()->restaurant?->id)
            ->count();

        $total_products = Item::where('restaurant_id', Auth::user()->restaurant?->id)
            ->count();

        $revenue = Order::where('restaurant_id', Auth::user()->restaurant?->id)
            ->with('restaurant')
            ->sum('total');

        $orders = Auth::user()->hasRole('admin') ? Order::with('restaurant')->get() : Order::where('restaurant_id', Auth::user()->restaurant->id)->with('restaurant')->get();
        // dd($orders);

        if ($request->expectsJson()) {
            // ...

        } else {
            return Inertia::render('Order/Index', [
                'orders' => $orders,
                'total_orders' => $total_orders,
                'revenue' => $revenue,
                'products' => $total_products,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Order/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {

        $order->load(['restaurant', 'orderDetails']);
        $order_details = OrderDetails::where('order_id', $order->id)->with('item')->get();

        return Inertia::render('Order/Show', [
            'order' => $order,
            'order_details' => $order_details,
            'order_status' => array_column(OrderStatus::cases(), 'value'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        // dd($request->status);

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->banner('Order #' . $order->id . ' has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->back()->banner('Order: ' . $order->name . ' has been deleted');
    }
}
