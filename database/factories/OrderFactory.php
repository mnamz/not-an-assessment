<?php

namespace Database\Factories;

use App\Enums\OrderDelivery;
use App\Enums\OrderPayment;
use App\Enums\OrderStatus;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_name' => $this->faker->name,
            'restaurant_id' => Restaurant::all()->random()->id,
            'method' => $this->faker->randomElement(array_column(OrderDelivery::cases(), 'value')),
            'payment' => $this->faker->randomElement(array_column(OrderPayment::cases(), 'value')),
            'status' => $this->faker->randomElement(array_column(OrderStatus::cases(), 'value')),
            'details' => $this->faker->sentence,
            'address' => $this->faker->address(),
            'total' => 0,
        ];
    }
}
