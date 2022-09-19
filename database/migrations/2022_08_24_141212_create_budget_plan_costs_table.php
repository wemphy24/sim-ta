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
        Schema::create('budget_plan_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotations_id')->index('fk_budget_plan_costs_to_quotations');
            $table->string('budget_plan_code')->nullable();
            $table->string('budget_cost_code')->nullable();
            $table->longText('description')->nullable();
            $table->date('date');
            $table->foreignId('status_id')->index('fk_budget_plan_costs_to_status');
            $table->foreignId('users_id')->index('fk_budget_plan_costs_to_users');
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
        Schema::dropIfExists('budget_plan_costs');
    }
};
