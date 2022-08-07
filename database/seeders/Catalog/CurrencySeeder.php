<?php

namespace Database\Seeders\Catalog;

use App\Catalog\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Создаёт валюту тенге
     *
     * @return void
     */
    public function run()
    {
        $currency = Currency::whereCode('KZT')->get()->first();
        if(!$currency) {
            $currency = new Currency();
        }

        $currency->name = 'Казахстанский тенге';
        $currency->code = 'KZT';
        $currency->base = true;

        $currency->save();
    }
}
