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
        Schema::create('rabp_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rabps_id')->constrained('rabps')->onUpdate('CASCADE');
            $table->foreignId('goods_id')->constrained('goods')->onUpdate('CASCADE');
            $table->foreignId('materials_id')->constrained('materials')->onUpdate('CASCADE');
            $table->integer('qty');
            $table->integer('price');
            $table->integer('total_price');
            $table->integer('qty_received')->nullable();
            $table->integer('qty_install')->nullable();
            $table->integer('qty_remaining')->nullable();
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
        Schema::dropIfExists('rabp_materials');
    }
};
