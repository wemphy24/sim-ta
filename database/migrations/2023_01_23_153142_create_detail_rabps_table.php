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
        Schema::create('detail_rabps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rabps_id')->constrained('rabps')->onUpdate('CASCADE');
            $table->foreignId('set_goods_id')->constrained('set_goods')->onUpdate('CASCADE');
            $table->integer('qty')->nullable();
            $table->integer('price')->nullable();
            $table->integer('quality')->nullable(); // Tambahan
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
        Schema::dropIfExists('detail_rabps');
    }
};
