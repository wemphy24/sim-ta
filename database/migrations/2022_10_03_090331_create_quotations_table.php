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
            // $table->foreignId('inquiries_id')->constrained('inquiries')->onUpdate('CASCADE'); REVISI
            $table->string('quotation_code')->unique();
            $table->string('name');
            $table->longText('quotation_file')->nullable();
            $table->longText('inquiry_file')->nullable();
            $table->string('project')->nullable();
            $table->date('date');
            $table->string('location')->nullable();
            $table->foreignId('customers_id')->constrained('customers')->onUpdate('CASCADE');
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
        Schema::dropIfExists('quotations');
    }
};
