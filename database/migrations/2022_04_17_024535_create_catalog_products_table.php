<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('external_id')->nullable();
            $table->integer('sort')->unsigned()->default(500);
            $table->text('description')->nullable();

            /* Общие свойства */
            # brands
//            $table->foreignId('brand_id');
//            $table->foreign('brand_id')->references('id')->on('catalog_brands');

            # countries
//            $table->foreignId('country_id');
//            $table->foreign('country_id')->references('id')->on('countries');

            /**/
//            $table->string('plotnost_chulok_kalgotok'); //den
//            $table->string('razmer_ru');
//            $table->string('obhvat_grudi');
//            $table->integer('obhvat_grudi');


//            $table->foreignIdFor('size')->references('id')->on('catalog_prop_size_values');

//            $table->enum('obyem_grudi', [
//                "С",
//                "А",
//                "G",
//                "I",
//                "DD",
//                "D",
//                "E",
//                "F",
//                "В",
//                "H",
//                "J",
//            ]);
//            $table->enum('razmer_trusov', []);
//            $table->enum('vozrast', []);


            $table->timestamps();

            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalog_products');
    }
};
