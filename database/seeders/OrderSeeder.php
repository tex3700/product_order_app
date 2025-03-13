<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::pluck('id')->toArray();
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $product = Product::find($faker->randomElement($products));
            $quantity = $faker->numberBetween(1, 10);

            Order::create([
                'customer_name' => $faker->name,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'total_price' => $product->price * $quantity,
                'status' => $faker->randomElement(['новый', 'выполнен']),
                'comment' => $faker->optional(0.3)->sentence,
            ]);
        }
    }
}
