<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProductSeeder::class,
            CategorySeeder::class,
            PriceListSeeder::class,
            ProductRelationSeeder::class,
            UserSeeder::class,
            ContractListSeeder::class
        ]);
    }
}
