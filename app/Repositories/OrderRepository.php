<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function create(array $parameters, array $products): Order
    {
        return DB::transaction(function () use ($parameters, $products) {
            /** @var Order $order */
            $order = Order::query()->create($parameters);

            $order->products()->sync($products);

            return $order;
        });
    }
}
