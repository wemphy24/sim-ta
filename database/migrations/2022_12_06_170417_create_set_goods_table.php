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
        Schema::create('set_goods', function (Blueprint $table) {
            $table->id();
            $table->string('set_goods_code');
            $table->string('name');
            $table->integer('qty');
            $table->integer('price');
            $table->foreignId('categories_id')->constrained('categories')->onUpdate('CASCADE');
            $table->foreignId('measurements_id')->constrained('measurements')->onUpdate('CASCADE');
            $table->foreignId('quotations_id')->constrained('quotations')->onUpdate('CASCADE'); // Tambahan
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
        Schema::dropIfExists('fk_set_goods_to_categories');
        Schema::dropIfExists('fk_set_goods_to_measurements');
    }
};
