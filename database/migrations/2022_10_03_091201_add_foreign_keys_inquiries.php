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
        Schema::table('inquiries', function (Blueprint $table) {
            $table->foreign('customers_id', 'fk_inquiries_to_customers')->references('id')->on('customers')->onUpdate('CASCADE');
            $table->foreign('status_id', 'fk_inquiries_to_status')->references('id')->on('status')->onUpdate('CASCADE');
            $table->foreign('users_id', 'fk_inquiries_to_users')->references('id')->on('users')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropForeign('fk_inquiries_to_customers');
            $table->dropForeign('fk_inquiries_to_status');
            $table->dropForeign('fk_inquiries_to_users');
        });
    }
};
