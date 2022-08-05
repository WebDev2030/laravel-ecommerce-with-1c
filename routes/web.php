<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
//    App::basePath();
    $filepath = base_path() . "/storage/1cExchange/2022-06-12_15-57-14_e8b58f0def346a0a8f2c288ac7e9f4e4/import___8692c389-162a-49cb-b54c-075662d6ac0f.xml";
    $parser = new \App\OneCExchange\ImportFileParser($filepath);
    $parser->parse();

//    $property = new \App\Properties\Property();
//    $property->name = 'Страна';
//    $property->model_type = \App\Catalog\Models\Product::class;
//    $property->type = 'string';
//    $property->save();
//
//    $property = \App\Properties\Property::first();
//
//    $product = new \App\Catalog\Models\Product();
//    $product->name = 'Тестовый товар';
//    $product->save();
//
//    $product = \App\Catalog\Models\Product::first();
//
//    dd($product->values()->groupBy('property_id')->get());
//    $value = new \App\Properties\Value();
//    $value->property_id = $property->id;
//    $value->value_string = 'Казахстан';
//
//    $product->values()->save($value);

//    $props = $product->properties()->get();
//    $values = $product->values()->create();

//    dd($values);


    return view('welcome');
});

Route::any('/exchange', [\App\Http\Controllers\Exchenge::class, 'catalogIn'])
    ->middleware(config('protocolExchange1C.middleware'))
    ->name('1sProtocolCatalog');;

//Route::group(
//    [
//        'namespace'  => 'Mavsan\LaProtocol\Http\Controllers',
//        'middleware' => config('protocolExchange1C.middleware'),
//    ],
//    function () {
//        Route::match(
//            ['get', 'post'],
//            '/exchange',
//            [\App\Http\Controllers\Exchenge::class, 'catalogIn']
//        )->name('1sProtocolCatalog');
//    }
//);
