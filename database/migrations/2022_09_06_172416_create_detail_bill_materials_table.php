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
        Schema::create('detail_bill_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_materials_id')->index('fk_detail_bill_materials_to_bill_materials');
            $table->integer('total_price_rap');
            $table->integer('overhead_cost');
            $table->integer('preliminary_cost');
            $table->integer('profit');
            $table->integer('ppn');
            $table->integer('total_price_rabp');
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
        Schema::dropIfExists('detail_bill_materials');
    }
};
