<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    public function create(array $parameters, array $products): Order
    {
        /** @var Order $order */
        $order = Order::query()->create($parameters);

        $order->products()->sync($products);

        return $order;
    }
}
