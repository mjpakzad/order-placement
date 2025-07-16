<?php

namespace Modules\Order\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_orders_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('orders', [
            'id', 'user_id', 'shipping_method', 'products_total_price', 'shipping_cost', 'total_price', 'status', 'created_at', 'updated_at',
        ]), 'Orders table does not have expected columns.');
    }
}
