<?php

namespace Database\Seeders;

use Database\Seeders\Catalog\Attribute;
use Database\Seeders\Catalog\CurrencySeeder;
use Database\Seeders\Catalog\ProductSeeder;
use Database\Seeders\EAV\AttributeSeeder;
use Database\Seeders\EAV\EntitySeeder;
use Database\Seeders\OneCExchange\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CurrencySeeder::class,

            AttributeSeeder::class,

            ProductSeeder::class,
        ]);
    }
}
