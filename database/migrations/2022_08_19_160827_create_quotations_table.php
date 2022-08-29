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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('quotation_code')->unique();
            $table->string('name');
            $table->string('project')->nullable();
            $table->date('date');
            $table->string('location')->nullable();
            $table->foreignId('customers_id')->index('fk_quotations_to_customers');
            $table->foreignId('status_id')->index('fk_quotations_to_status');
            $table->foreignId('users_id')->index('fk_quotations_to_users');
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
        Schema::dropIfExists('quotations');
    }
};
