<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Restaurant::class;

    public function definition(): array
    {
        $categories = Category::factory()->count(2)->create()->pluck('name')->toArray();

        return [
            'name' => $this->faker->company,
            'categories' => json_encode($categories),
            'location' => $this->faker->address,
            'user_id' => User::factory(),
        ];
    }
}
