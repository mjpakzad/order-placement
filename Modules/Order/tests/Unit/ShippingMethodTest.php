<?php

namespace Modules\Order\Tests\Unit;

use Modules\Order\Enums\OrderStatus;
use Modules\Order\Enums\ShippingMethod;
use Tests\TestCase;

class ShippingMethodTest extends TestCase
{
    public function order_has_expected_statuses(): void
    {
        $statuses = [
            'POST' => 0,
            'TIPAX' => 1,
            'CHAPAR' => 2,
        ];
        $this->assertEquals($statuses, ShippingMethod::options());
    }
}
