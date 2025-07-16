<?php

namespace Modules\Product\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Modules\Product\Models\Product;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ImportProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'product:import';

    /**
     * The console command description.
     */
    protected $description = 'Import products from external API and store them in database.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle() {
        $url = 'https://dummyjson.com/products?limit=10&skip=10&select=title,price,stock';

        $response = Http::get($url);
        if (!$response->ok()) {
            $this->error('Failed to fetch data');
            return 1;
        }

        foreach ($response->json('products') as $item) {
            DB::table('products')->updateOrInsert(
                ['id' => $item['id']],
                [
                    'title' => $item['title'],
                    'price' => $item['price'],
                    'stock' => $item['stock'],
                ]
            );
        }

        $this->info('Products imported successfully.');
        return 0;
    }
}
