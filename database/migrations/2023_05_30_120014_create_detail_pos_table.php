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
        Schema::create('detail_pos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_orders_id')->constrained('purchase_orders')->onUpdate('CASCADE');
            $table->foreignId('materials_id')->constrained('materials')->onUpdate('CASCADE');
            $table->integer('qty')->nullable();
            $table->integer('price')->nullable();
            $table->integer('total_price')->nullable();
            $table->date('order_date'); // TAMBAHAN
            $table->date('received_date')->nullable(); // TAMBAHAN
            $table->string('status')->nullable();
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
        Schema::dropIfExists('detail_pos');
    }
};
