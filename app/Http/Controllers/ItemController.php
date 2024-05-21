<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

use function Termwind\render;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            $items = Item::with('restaurant')->get();
            return ItemResource::collection($items);
        } else {
            $items = Auth::user()->hasRole('admin') ? Item::with('restaurant')->get() : Item::where('restaurant_id', Auth::user()->restaurant->id)->with('restaurant')->get();
            return Inertia::render('Product/Index', [
                'products' => $items,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Product/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->hasFile('attachment')) {
            $path = $request->file('image')->store('image');
        } else {
            $path = null;
        }

        $item = Item::create([
            'name' => $request->name,
            'restaurant_id' => Auth::user()->restaurant?->id ?? 1,
            'price' => $request->price,
            'image' => $path,
            'details' => $request->details,
        ]);

        return redirect()->route('products.index')->banner('Product: ' . $item->name . ' has been created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }
}
