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
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('productions_id')->constrained('productions')->onUpdate('CASCADE');
            $table->string('purchase_request_code')->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->date('deadline');
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
        Schema::dropIfExists('purchase_requests');
    }
};
