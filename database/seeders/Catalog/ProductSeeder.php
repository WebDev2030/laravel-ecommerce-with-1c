<?php

namespace Database\Seeders\Catalog;

use App\Catalog\Models\Currency;
use App\Catalog\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Создаёт валюту тенге
     *
     * @return void
     */
    public function run()
    {
        $product = Product::whereSlug('test')->get()->first();
        if(!$product) {
            $product = new Product();
        }

        $product->name = 'Тестовый товар';
        $product->slug = 'test';

        $product->save();
    }
}
