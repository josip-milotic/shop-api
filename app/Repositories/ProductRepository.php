<?php

namespace App\Repositories;

use App\Models\ContractList;
use App\Models\User;

class ProductRepository
{
    public function getProductsForUser(User $user, int $pageSize, int $page): array
    {
        $productsList = [];
        $priceList = $user->priceList;

        $products = $priceList->products()
            ->where('published', true)
            ->limit($pageSize)
            ->offset($pageSize * $page)
            ->get();

        $contractedProducts = ContractList::query()
            ->where('user_id', $user->id)
            ->whereIn('product_id', $products->pluck('id')->toArray())
            ->get();

        foreach ($products as $product) {
            $contractedProduct = $contractedProducts->where('product_id', $product->id)->first();

            $productsList[] = [
                'id' => $product->pivot->product_id,
                'name' => $product->pivot->name,
                'price' => $contractedProduct ? $contractedProduct->price : $product->pivot->price,
                'sku' => $contractedProduct ? $contractedProduct->sku : $product->pivot->sku,
            ];
        }

        return $productsList;
    }

    public function getProductForUser(User $user, int $productId): ?array
    {
        $priceList = $user->priceList;

        $product = $priceList->products()
            ->where('published', true)
            ->where('id', $productId)
            ->first();

        $contractedProduct = ContractList::query()
            ->where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if (!$product && !$contractedProduct) {
            return null;
        }

        return [
            'id' => $product->pivot->product_id,
            'name' => $product->pivot->name,
            'price' => $contractedProduct ? $contractedProduct->price : $product->pivot->price,
            'sku' => $contractedProduct ? $contractedProduct->sku : $product->pivot->sku,
        ];
    }
}
