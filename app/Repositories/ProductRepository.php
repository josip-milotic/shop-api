<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function getProductsForUser(User $user, int $pageSize, int $page): Collection
    {
        return $this->getFinalProducts($user)
            ->limit($pageSize)
            ->offset($pageSize * ($page - 1))
            ->get();
    }

    public function getProductForUser(User $user, int $productId): ?Model
    {
        return $this->getFinalProducts($user)
            ->where('products.id', $productId)
            ->first();
    }

    public function getProductsForUserInCategory(User $user, int $pageSize, int $page, int $categoryId): Collection
    {
        return $this->getFinalProducts($user)
            ->whereHas('categories', function ($query) use ($categoryId) {
                return $query->where('id', $categoryId);
            })
            ->limit($pageSize)
            ->offset($pageSize * ($page - 1))
            ->get();
    }

    protected function getFinalProducts(User $user): Builder
    {
        return Product::query()->select(
            'products.id',
            'price_list_product.name',
            DB::raw('COALESCE(contract_lists.price, price_list_product.price) as price'),
            DB::raw('COALESCE(contract_lists.sku, price_list_product.sku) as sku'),
        )
            ->join('price_list_product', 'products.id', '=', 'price_list_product.product_id')
            ->leftJoin('contract_lists', function ($join) use ($user) {
                $join->on('products.id', '=', 'contract_lists.product_id')
                    ->where(function ($query) use ($user) {
                        $query->where('contract_lists.user_id', $user->id)
                            ->orWhereNull('contract_lists.user_id');
                    });
            })
            ->where('products.published', true)
            ->where('price_list_product.price_list_id', $user->price_list_id);
    }
}
