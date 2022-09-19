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
        Schema::table('budget_plan_costs', function (Blueprint $table) {
            $table->foreign('quotations_id', 'fk_budget_plan_costs_to_quotations')->references('id')->on('quotations')->onUpdate('CASCADE');
            $table->foreign('status_id', 'fk_budget_plan_costs_to_status')->references('id')->on('status')->onUpdate('CASCADE');
            $table->foreign('users_id', 'fk_budget_plan_costs_to_users')->references('id')->on('users')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_plan_costs', function (Blueprint $table) {
            $table->dropForeign('fk_budget_plan_costs_to_quotations');
            $table->dropForeign('fk_budget_plan_costs_to_status');
            $table->dropForeign('fk_budget_plan_costs_to_users');
        });
    }
};
