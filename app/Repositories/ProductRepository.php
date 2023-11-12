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
    public function getProducts(User $user, int $pageSize, int $page): Collection
    {
        return $this->getFinalProducts($user)
            ->limit($pageSize)
            ->offset($pageSize * ($page - 1))
            ->get();
    }

    public function getProduct(User $user, int $productId): ?Model
    {
        return $this->getFinalProducts($user)
            ->where('products.id', $productId)
            ->first();
    }

    public function getProductsInCategory(User $user, int $pageSize, int $page, int $categoryId): Collection
    {
        return $this->getFinalProducts($user)
            ->whereHas('categories', function ($query) use ($categoryId) {
                return $query->where('id', $categoryId);
            })
            ->limit($pageSize)
            ->offset($pageSize * ($page - 1))
            ->get();
    }

    public function getFilteredProducts(User $user, int $pageSize, int $page, string $orderBy, string $order): Collection
    {
        return $this->getFinalProducts($user)
            ->orderBy($orderBy, $order)
            ->limit($pageSize)
            ->offset($pageSize * ($page - 1))
            ->get();
    }

    protected function getFinalProducts(User $user): Builder
    {
        return Product::query()->select(
            'products.id',
            'products.name',
            'products.sku',
            'products.stock',
            'products.created_at',
            DB::raw('COALESCE(contract_lists.price, price_list_product.price, products.price) as price'),
        )
            ->leftJoin('price_list_product', function ($join) use ($user) {
                $join->on('products.id', '=', 'price_list_product.product_id')
                    ->where(function ($query) use ($user) {
                        $query->where('price_list_product.price_list_id', $user->price_list_id)
                            ->orWhereNull('price_list_product.price_list_id');
                    });
            })
            ->leftJoin('contract_lists', function ($join) use ($user) {
                $join->on('products.id', '=', 'contract_lists.product_id')
                    ->where(function ($query) use ($user) {
                        $query->where('contract_lists.user_id', $user->id)
                            ->orWhereNull('contract_lists.user_id');
                    });
            })
            ->where('products.published', true);
    }
}
