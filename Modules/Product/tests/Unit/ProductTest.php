<?php

namespace Modules\Auth\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('products', [
            'id', 'title', 'price', 'stock', 'created_at', 'updated_at',
        ]), 'Products table does not have expected columns.');
    }
}
