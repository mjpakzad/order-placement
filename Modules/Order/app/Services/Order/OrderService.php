<?php

namespace Modules\Order\Services\Order;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\Order\Enums\OrderStatus;
use Modules\Order\Enums\ShippingMethod;
use Modules\Order\Models\Order;
use Modules\Order\Models\OrderProduct;
use Modules\Product\Models\Product;

class OrderService
{
    public function createOrder(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $productItems = $this->processProducts($data['products']);
            $productsTotal = collect($productItems)->sum('total_price');

            $shippingMethod = ShippingMethod::fromName($data['shipping_method']);
            $shippingCost = $shippingMethod->price();

            $order = $this->storeOrder(
                userId: auth()->id(),
                productsTotal: $productsTotal,
                shippingCost: $shippingCost,
                shippingMethod: $shippingMethod
            );

            $this->attachProductsToOrder($order, $productItems);

            return $order->load('orderProducts');
        });
    }

    private function processProducts(array $items): array
    {
        $result = [];

        foreach ($items as $item) {
            $productId = $item['id'];
            $quantity = $item['quantity'];
            $lockKey = "lock:product:$productId";

            $lock = Cache::lock($lockKey, 5);

            $lock->block(3, function () use (&$result, $productId, $quantity) {
                $product = Product::query()->findOrFail($productId);

                if ($product->stock < $quantity) {
                    throw new \RuntimeException(__("Insufficient stock for product \":title\".", [
                        'title' => $product->title,
                    ]));
                }

                $product->decrement('stock', $quantity);

                $result[] = [
                    'product_id'  => $product->id,
                    'quantity'    => $quantity,
                    'price'       => $product->price,
                    'total_price' => $quantity * $product->price,
                ];
            });
        }

        return $result;
    }

    private function storeOrder(int $userId, float $productsTotal, float $shippingCost, ShippingMethod $shippingMethod): Order
    {
        return Order::query()->create([
            'user_id'              => $userId,
            'shipping_method'      => $shippingMethod->value,
            'products_total_price' => $productsTotal,
            'shipping_cost'        => $shippingCost,
            'total_price'          => $productsTotal + $shippingCost,
            'status'               => OrderStatus::PAID->value,
        ]);
    }

    private function attachProductsToOrder(Order $order, array $items): void
    {
        foreach ($items as $item) {
            $item['order_id'] = $order->id;
            OrderProduct::query()->create($item);
        }
    }
}
