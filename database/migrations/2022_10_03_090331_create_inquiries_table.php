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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('inquiry_file');
            $table->longText('purchase_order_file')->nullable();
            $table->date('date');
            $table->foreignId('customers_id')->index('fk_inquiries_to_customers');
            $table->foreignId('status_id')->index('fk_inquiries_to_status');
            $table->foreignId('users_id')->index('fk_inquiries_to_users');
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
        Schema::dropIfExists('inquiries');
    }
};
