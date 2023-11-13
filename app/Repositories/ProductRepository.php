<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProductRepository
{
    public function getProducts(User $user, int $pageSize, int $page): Collection
    {
        return Product::query()->forUser($user)
            ->limit($pageSize)
            ->offset($pageSize * ($page - 1))
            ->get();
    }

    public function getProduct(User $user, int $productId): ?Model
    {
        return Product::query()->forUser($user)
            ->where('products.id', $productId)
            ->first();
    }

    public function getProductsInCategory(User $user, int $pageSize, int $page, int $categoryId): Collection
    {
        return Product::query()->forUser($user)
            ->whereHas('categories', function ($query) use ($categoryId) {
                return $query->where('id', $categoryId);
            })
            ->limit($pageSize)
            ->offset($pageSize * ($page - 1))
            ->get();
    }

    public function getFilteredProducts(User   $user,
                                        int    $pageSize,
                                        int    $page,
                                        string $orderBy,
                                        string $order,
                                        ?int    $priceMin,
                                        ?int    $priceMax,
                                        ?string $name,
                                        ?array  $categoryIds
    ): Collection
    {
        return Product::query()->fromSub(Product::query()->forUser($user), 'products')
        ->when($priceMin, function ($query) use ($priceMin) {
            return $query->where('price', '>=', $priceMin);
        })
            ->when($priceMax, function ($query) use ($priceMax) {
                return $query->where('price', '<=', $priceMax);
            })
            ->when($name, function ($query) use ($name) {
                return $query->where('name', 'LIKE', "%$name%");
            })
            ->when($categoryIds, function ($query) use ($categoryIds) {
                return $query->whereHas('categories', function ($query) use ($categoryIds) {
                    return $query->whereIn('id', $categoryIds);
                }, '=', count($categoryIds));
            })
            ->orderBy($orderBy, $order)
            ->limit($pageSize)
            ->offset($pageSize * ($page - 1))
            ->get();
    }
}
