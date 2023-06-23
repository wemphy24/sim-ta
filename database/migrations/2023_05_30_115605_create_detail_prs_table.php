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
        Schema::create('detail_prs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_requests_id')->constrained('purchase_requests')->onUpdate('CASCADE');
            $table->foreignId('materials_id')->constrained('materials')->onUpdate('CASCADE');
            $table->integer('qty')->nullable();
            $table->foreignId('status_id')->constrained('status')->onUpdate('CASCADE');
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
        Schema::dropIfExists('detail_prs');
    }
};