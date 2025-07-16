<?php

namespace Modules\Order\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Order\Http\Requests\API\V1\StoreOrderRequest;
use Modules\Order\Services\Order\OrderService;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService) {}

    public function store(StoreOrderRequest $request): JsonResponse
    {
        $order = $this->orderService->createOrder($request->validated());
        return response()->json([
            'message' => __('Order placed successfully'),
            'order' => $order
        ]);
    }
}
