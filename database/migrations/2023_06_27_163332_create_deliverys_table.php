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
        Schema::create('deliverys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contracts_id')->constrained('contracts')->onUpdate('CASCADE');
            $table->foreignId('rabps_id')->constrained('rabps')->onUpdate('CASCADE');
            $table->string('delivery_code');
            $table->string('name');
            $table->string('description');
            $table->date('send_date');
            $table->date('done_date');
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
        Schema::dropIfExists('deliverys');
    }
};
