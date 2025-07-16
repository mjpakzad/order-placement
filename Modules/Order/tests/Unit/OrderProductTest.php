<?php

namespace Modules\Order\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class OrderProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_products_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('order_products', [
            'id', 'order_id', 'product_id', 'quantity', 'price', 'total_price', 'created_at', 'updated_at',
        ]), 'Order products table does not have expected columns.');
    }
}
