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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('model');
            $table->string('slug');
            $table->string('type'); // int, string, bool, dictionary, enum
            $table->json('settings'); // for dictionary {table_name: countries}
            $table->string('external_id')->nullable();
            $table->integer('sort')->unsigned()->default(500);
            $table->text('description')->nullable();

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
        Schema::dropIfExists('attributes');
    }
};
