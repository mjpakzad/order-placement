<?php

namespace Modules\Order\Tests\Unit;

use Modules\Order\Enums\OrderStatus;
use Tests\TestCase;

class OrderStatusTest extends TestCase
{
    public function order_has_expected_statuses(): void
    {
        $statuses = [
            'PAID' => 0,
            'SENT' => 1,
            'DELIVERED' => 2,
        ];
        $this->assertEquals($statuses, OrderStatus::options());
    }
}
