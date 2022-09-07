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
            $table->foreignId('budget_plans_id')->index('fk_bill_materials_to_budget_plans');
            $table->foreignId('materials_id')->index('fk_bill_materials_to_materials');
            $table->integer('quantity');
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
        Schema::dropIfExists('bill_materials');
    }
};
