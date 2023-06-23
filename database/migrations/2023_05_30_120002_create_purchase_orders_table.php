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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_requests_id')->constrained('purchase_requests')->onUpdate('CASCADE');
            $table->string('purchase_order_code')->unique();
            $table->string('name');
            $table->string('description');
            $table->date('deadline');
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
        Schema::dropIfExists('purchase_orders');
    }
};
