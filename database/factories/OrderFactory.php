<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            //'customer_name',
            //        'order_date',
            //        'status',
            //        'comment',
            //        'product_id',
            //        'quantity',
            //        'total_price'
            'customer_name' => $this->faker->name,
            'order_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['new', 'completed',]),
            'comment' => $this->faker->text,
            'product_id' => \App\Models\Product::factory(),
            'quantity' => $this->faker->numberBetween(1, 10),
            'total_price' => $this->faker->randomFloat(2, 1, 1000),
        ];
    }
}
