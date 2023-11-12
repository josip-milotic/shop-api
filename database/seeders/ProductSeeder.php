<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\TaxCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    protected const CHUNK_SIZE = 1000;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taxCategory = TaxCategory::query()->first();

        for ($i = 0; $i < 20000; $i += self::CHUNK_SIZE) {
            $products = Product::factory()->for($taxCategory)->count(self::CHUNK_SIZE)->raw();

            DB::table('products')->insert($products);
        }
    }
}
