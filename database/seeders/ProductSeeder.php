<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [];

        for ($i = 1; $i <= 180; $i++) {
            $products[] = [
                'name' => fake()->name(),
                'description' => fake()->text(50),
                'price' => fake()->numberBetween(100, 1000),
            ];
        }

        Product::insert($products);

        $this->command->info("Company " . count($products) . " created");

        $products = Product::all()->pluck(['id']);

        $stocks = [];

        for ($i = 0; $i < 180; $i++) {
            $stocks[] = [
                'product_id' => $products[$i],
                'amount' => fake()->numberBetween(100, 1000),
            ];
        }

        Stock::insert($stocks);

        $this->command->info("Price " . count($stocks) . " created");
    }
}
