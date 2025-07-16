<?php

namespace Modules\Order\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;
use Modules\Auth\Models\User;
use Modules\Product\Models\Product;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_place_order_successfully(): void
    {
        Redis::flushAll();

        $product = Product::factory()->create([
            'stock' => 10,
            'price' => 100_000,
        ]);

        $user = User::factory()->create();

        $payload = [
            'products' => [
                [
                    'id' => $product->id,
                    'quantity' => 2,
                ]
            ],
            'shipping_method' => 'post',
        ];

        $token = auth('api')->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/v1/orders', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'order' => [
                    'id',
                    'user_id',
                    'shipping_method',
                    'products_total_price',
                    'shipping_cost',
                    'total_price',
                    'status',
                    'order_products',
                ]
            ]);
    }
}
