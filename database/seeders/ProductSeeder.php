<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::pluck('id')->toArray();
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 30; $i++) {
            Product::create([
                'name' => $faker->words(2, true),
                'category_id' => $faker->randomElement($categories),
                'description' => $faker->sentence(10),
                'price' => $faker->randomFloat(2, 100, 10000),
            ]);
        }
    }
}
