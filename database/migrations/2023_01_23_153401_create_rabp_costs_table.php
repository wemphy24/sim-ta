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
        Schema::create('rabp_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rabps_id')->constrained('rabps')->onUpdate('CASCADE');
            $table->integer('overhead')->nullable();
            $table->integer('preliminary')->nullable();
            $table->integer('profit')->nullable();
            $table->integer('ppn')->nullable();
            $table->integer('total_profit')->nullable();
            $table->integer('total_price')->nullable();
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
        Schema::dropIfExists('rabp_costs');
    }
};
