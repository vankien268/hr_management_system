<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::truncate();
        $this->faker = Faker::create();
        $product = [
            'code' => 'NSP001',
            'name' => 'Máy đọc thẻ ver',
            'product_group_id' => 2,
            'unit_id' => 1,
            'price' => 1650000,
            'edit_price' => 1,
            'image_link' => null,
            'note' => 'Ghi chú',
            'status' => 1
        ];
        for($i = 1; $i <= 100; $i ++) {
            $productNew = [...$product];
            $productNew['code'] = $productNew['code']. $i;
            $productNew['name'] = $productNew['name'].' '. $i;
            $productNew['price'] = $productNew['price'] + rand(100000,5000000);
            $productNew['note'] = $productNew['note'].' '.$i;
            Product::create($productNew);
        }
    }
}
