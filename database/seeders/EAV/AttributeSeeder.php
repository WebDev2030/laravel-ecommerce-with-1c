<?php

namespace Database\Seeders\EAV;

use App\Catalog\Models\Product;
use App\EAV\Models\Attribute;
use App\EAV\Models\Entity;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Создаёт валюту тенге
     *
     * @return void
     */
    public function run()
    {
        $attribute = Attribute::query()
            ->whereModel(Product::class)
            ->whereSlug('material')
            ->get()
            ->first();

        if(!$attribute) {
            $attribute = new Attribute();
        }

        $attribute->name = 'Материал';
        $attribute->model = Product::class;
        $attribute->type = 'string';
        $attribute->slug = 'material';
        $attribute->settings = json_encode([]);
        $attribute->sort = 500;
        $attribute->description = "Материал, из которого сделан товар";

        $attribute->save();
    }
}
