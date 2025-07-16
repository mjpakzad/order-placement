<?php

namespace Modules\Product\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'id'    => $this->faker->unique()->numberBetween(1, 999999),
            'title' => $this->faker->sentence(3),
            'price' => $this->faker->randomFloat(2, 100, 50000),
            'stock' => $this->faker->numberBetween(0, 100),
        ];
    }
}
