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
        Schema::create('good_receives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_orders_id')->constrained('purchase_orders')->onUpdate('CASCADE');
            $table->string('good_receive_code');
            $table->foreignId('materials_id')->constrained('materials')->onUpdate('CASCADE');
            $table->integer('qty');
            $table->integer('qty_order');
            $table->integer('qty_accept');
            $table->integer('price');
            $table->date('print_date');
            $table->foreignId('suppliers_id')->constrained('suppliers')->onUpdate('CASCADE');
            $table->foreignId('status_id')->constrained('status')->onUpdate('CASCADE');
            $table->foreignId('users_id')->constrained('users')->onUpdate('CASCADE');
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
        Schema::dropIfExists('good_receives');
    }
};
