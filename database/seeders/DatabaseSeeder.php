<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Restaurant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            UserSeeder::class,
        ]);

        $categories = Category::factory()->count(5)->create();

        // $restaurants = Restaurant::factory()
        //     ->count(3)
        //     ->create()
        //     ->each(function ($restaurant) use ($categories) {
        //         $restaurant->categories = $categories->random(2)->pluck('name')->toArray();
        //         $restaurant->save();

        //         Item::factory()->count(10)->create(['restaurant_id' => $restaurant->id]);
        //     });

        $restaurants = Restaurant::factory()
            ->count(5)
            ->create()
            ->each(function ($restaurant) use ($categories) {
                // Assign random categories to each restaurant
                $restaurant->categories = $categories->random(2)->pluck('name')->toArray();
                $restaurant->save();

                // Create items for each restaurant
                Item::factory()->count(10)->create(['restaurant_id' => $restaurant->id]);
            });


        Order::factory()
            ->count(10)
            ->create()
            ->each(function ($order) {
                $items = Item::inRandomOrder()->take(rand(1, 5))->get();
                foreach ($items as $item) {
                    OrderDetails::factory()->create([
                        'order_id' => $order->id,
                        'item_id' => $item->id,
                    ]);
                }
            });
    }
}
