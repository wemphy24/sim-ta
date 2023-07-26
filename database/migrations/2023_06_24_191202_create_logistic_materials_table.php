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
        Schema::create('logistic_materials', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('set_goods_id')->nullable()->constrained('set_goods')->onUpdate('CASCADE');
            $table->foreignId('goods_id')->nullable()->constrained('goods')->onUpdate('CASCADE'); // REVISI
            $table->string('logistic_code');
            $table->foreignId('materials_id')->nullable()->constrained('materials')->onUpdate('CASCADE');
            $table->integer('qty_ask');
            $table->integer('qty_stock');
            $table->integer('price');
            $table->string('type'); //Berubah
            $table->foreignId('categories_id')->constrained('categories')->onUpdate('CASCADE');
            $table->foreignId('measurements_id')->constrained('measurements')->onUpdate('CASCADE');
            $table->foreignId('users_id')->constrained('users')->onUpdate('CASCADE');
            $table->foreignId('status_id')->constrained('status')->onUpdate('CASCADE');
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
        Schema::dropIfExists('logistic_materials');
    }
};
