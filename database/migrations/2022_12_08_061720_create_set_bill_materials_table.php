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
        Schema::create('set_bill_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('set_goods_id')->constrained('set_goods')->onUpdate('CASCADE');
            $table->foreignId('materials_id')->constrained('materials')->onUpdate('CASCADE');
            $table->integer('qty');
            $table->integer('price'); 
            $table->integer('total_price'); 
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
        Schema::dropIfExists('fk_set_bill_materials_to_set_goods');
        Schema::dropIfExists('fk_set_bill_materials_to_materials');
    }
};
