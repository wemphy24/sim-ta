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
        Schema::table('bill_materials', function (Blueprint $table) {
            $table->foreign('budget_plans_id', 'fk_bill_materials_to_budget_plans')->references('id')->on('budget_plans')->onUpdate('CASCADE');
            $table->foreign('materials_id', 'fk_bill_materials_to_materials')->references('id')->on('materials')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bill_materials', function (Blueprint $table) {
            $table->dropForeign('fk_bill_materials_to_budget_plans');
            $table->dropForeign('fk_bill_materials_to_materials');
        });
    }
};
