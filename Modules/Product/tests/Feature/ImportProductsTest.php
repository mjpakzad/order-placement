<?php

namespace Modules\Product\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ImportProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_are_imported_from_api()
    {
        Http::fake([
            'dummyjson.com/*' => Http::response([
                'products' => [
                    ['id' => 11, 'title' => 'Test Product', 'price' => 99.99, 'stock' => 10],
                ]
            ])
        ]);

        $this->artisan('product:import')
            ->expectsOutput('Products imported successfully.')
            ->assertExitCode(0);

        $this->assertDatabaseHas('products', ['id' => 11, 'title' => 'Test Product']);
    }
}
