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
        Schema::create('bill_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goods_id')->constrained('goods')->onUpdate('CASCADE');
            $table->foreignId('materials_id')->constrained('materials')->onUpdate('CASCADE');
            $table->integer('qty');
            $table->integer('price');
            $table->integer('total_price');
            $table->integer('qty_received');
            $table->integer('qty_install');
            $table->integer('qty_remaining');
            $table->string('status');
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
        Schema::dropIfExists('bill_materials');
    }
};
