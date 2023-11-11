<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\PriceList;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all('id');
        $priceLists = PriceList::all('id');

        Product::query()->chunk(5000, function ($products) use ($categories, $priceLists) {
            $productCategory = [];
            $productPriceList = [];

            foreach ($products as $product) {
                $randCategories = $categories->random(rand(1, 3));
                foreach ($randCategories as $category) {
                    $productCategory[] = [
                        'product_id' => $product->id,
                        'category_id' => $category->id
                    ];
                }

                $randPriceLists = $priceLists->random(rand(10, 20));
                foreach ($randPriceLists as $priceList) {
                    $productPriceList[] = [
                        'product_id' => $product->id,
                        'price_list_id' => $priceList->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'sku' => $product->sku,
                        'created_at' => now()->format('Y-m-d H:i:s'),
                        'updated_at' => now()->format('Y-m-d H:i:s'),
                    ];
                }
            }

            DB::table('category_product')->insert($productCategory);
            foreach (array_chunk($productPriceList,5000) as $chunk)
            {
                DB::table('price_list_product')->insert($chunk);
            }
        });
    }
}
