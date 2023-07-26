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
        Schema::create('goods', function (Blueprint $table) {
            $table->id();
            $table->string('good_code');
            $table->string('name');
            $table->integer('stock');
            $table->integer('price')->nullable();
            $table->integer('sell_price')->nullable();
            $table->foreignId('categories_id')->constrained('categories')->onUpdate('CASCADE');
            $table->foreignId('measurements_id')->constrained('measurements')->onUpdate('CASCADE');
            $table->foreignId('customers_id')->constrained('customers')->onUpdate('CASCADE');
            $table->foreignId('users_id')->constrained('users')->onUpdate('CASCADE');
            $table->enum('status_production', ['Siap Dirakit', 'Sedang Dirakit', 'Selesai Dirakit','Selesai Produksi', 'Sedang QC', 'Selesai QC']); // Tambahan
            $table->string('status_delivery')->nullable();
            $table->enum('status_qc', ['OK', 'On Hold'])->nullable();
            $table->date('start_prod')->nullable();
            $table->date('end_prod')->nullable();
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
        Schema::dropIfExists('goods');
    }
};
