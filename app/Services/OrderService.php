<?php

namespace App\Services;

use App\Helpers\Calculator;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Product;
use App\Models\TaxCategory;
use App\Models\User;
use Illuminate\Support\Arr;

class OrderService
{
    public function createOrder(User $user, array $parameters): Order
    {
        $productCollection = collect(Arr::get($parameters, 'products', []));

        $products = Product::query()
            ->forUser($user)
            ->whereIn('products.id', $productCollection->pluck('id')
                ->toArray())
            ->get();

        // Get all tax categories in one query since eager loading doesn't work with query builder
        $taxCategories = TaxCategory::query()->whereIn('id', $products->pluck('tax_category_id')->unique())->get();

        $discounts = Discount::query()->whereIn('id', Arr::get($parameters, 'discount_ids', []))->get();

        $totalPrice = 0;

        $forAttach = [];

        // To get the final price for each product, the tax is applied after discounts for the sake of simplicity.
        // In reality, this should probably be configurable as these rules vary
        foreach ($products as $product) {
            $price = $product->price;
            $quantity = Arr::get($productCollection->where('id', $product->id)->first(), 'quantity');

            foreach ($discounts as $discount) {
                $price = Calculator::multiply($price, $discount->discount_rate);
            }

            $price = Calculator::multiply(
                $price,
                Arr::get($taxCategories->where('id', $product->tax_category_id)->first(), 'tax_rate', 1)
            );

            $totalPrice = Calculator::add($totalPrice, Calculator::multiply($price, $quantity));

            $forAttach[$product->id] = [
                'price' => $price,
                'quantity' => $quantity,
            ];
        }

        /** @var Order $order */
        $order = Order::query()->create([
            'user_id' => $user->id,
            'total_price' => $totalPrice,
            'first_name' => Arr::get($parameters, 'first_name'),
            'last_name' => Arr::get($parameters, 'last_name'),
            'email' => Arr::get($parameters, 'email'),
            'address' => Arr::get($parameters, 'address'),
            'city' => Arr::get($parameters, 'city'),
            'country' => Arr::get($parameters, 'country'),
        ]);

        $order->products()->sync($forAttach);

        return $order;
    }
}
