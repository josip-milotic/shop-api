<?php

namespace Database\Seeders;

use App\Models\ContractList;
use App\Models\User;
use Illuminate\Database\Seeder;

class ContractListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $contractList = [];

        foreach ($users as $user) {
            foreach ($user->priceList->products()->inRandomOrder()->limit(50)->get() as $product) {
                $contractList[] = [
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'price' => $product->price * (rand(0, 20) / 10),
                    'created_at' => now()->format('Y-m-d H:i:s'),
                    'updated_at' => now()->format('Y-m-d H:i:s'),
                ];
            }
        }

        ContractList::query()->insert($contractList);
    }
}
