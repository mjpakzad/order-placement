<?php

namespace Modules\Order\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Auth\Models\User;
use Modules\Order\Enums\ShippingMethod;
use Modules\Order\Models\Order;
use Modules\Order\Models\OrderProduct;
use Modules\Product\Models\Product;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $shipping = fake()->randomElement(ShippingMethod::cases());

        return [
            'user_id'         => User::factory(),
            'total_price'     => fake()->numberBetween(100_000, 500_000),
            'shipping_method' => $shipping->value,
            'shipping_cost'   => $shipping->cost(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            $products = Product::query()->inRandomOrder()->take(rand(1, 3))->get();

            $total = 0;
            foreach ($products as $product) {
                $quantity = rand(1, min(5, $product->stock));
                $totalPrice = $product->price * $quantity;
                $total += $totalPrice;

                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'total_price' => $totalPrice,
                ]);
            }

            $order->update(['products_total_price' => $total]);
        });
    }
}

