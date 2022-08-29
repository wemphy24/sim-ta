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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categories_id')->index('fk_materials_to_categories');
            $table->foreignId('measurements_id')->index('fk_materials_to_measurements');
            $table->string('name');
            $table->integer('stock');
            $table->integer('price')->nullable();
            $table->integer('min_stock')->nullable();;
            $table->integer('max_stock')->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials');
    }
};
