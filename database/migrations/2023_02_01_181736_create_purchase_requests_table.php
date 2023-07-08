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
            // $table->foreignId('productions_id')->constrained('productions')->onUpdate('CASCADE');
            $table->string('purchase_request_code')->unique();
            $table->foreignId('materials_id')->constrained('materials')->onUpdate('CASCADE');
            $table->integer('qty_ask');
            $table->string('description')->nullable();
            $table->date('deadline');
            $table->foreignId('categories_id')->constrained('categories')->onUpdate('CASCADE');
            $table->foreignId('measurements_id')->constrained('measurements')->onUpdate('CASCADE');
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
