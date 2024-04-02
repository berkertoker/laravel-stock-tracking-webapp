<?php

namespace Database\Seeders;

use App\Models\Products;
use App\Models\Stocks;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [];

        for ($i = 1; $i <= 100; $i++) {
            $products[] = [
                'name' => fake()->name(),
                'description' => fake()->text(50),
                'price' => fake()->numberBetween(100, 1000),
            ];
        }

        Products::insert($products);

        $this->command->info("Company " . count($products) . " created");

        $products = Products::all()->pluck(['id']);

        $stocks = [];

        for ($i = 0; $i < 100; $i++) {
            $stocks[] = [
                'product_id' => $products[$i],
                'amount' => fake()->numberBetween(100, 1000),
            ];
        }

        Stocks::insert($stocks);

        $this->command->info("Price " . count($products) . " created");
    }
}
