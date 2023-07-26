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
        Schema::create('rabps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotations_id')->constrained('quotations')->onUpdate('CASCADE');
            $table->string('rabp_code')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('discount')->nullable(); // TAMBAHAN
            $table->integer('rabp_value')->nullable(); // TAMBAHAN
            $table->date('date');
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
        Schema::dropIfExists('rabps');
    }
};
