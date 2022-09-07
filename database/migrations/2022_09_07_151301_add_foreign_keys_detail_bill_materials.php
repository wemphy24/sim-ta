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
        Schema::table('detail_bill_materials', function (Blueprint $table) {
            $table->foreign('bill_materials_id', 'fk_detail_bill_materials_to_bill_materials')->references('id')->on('bill_materials')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_bill_materials', function (Blueprint $table) {
            $table->dropForeign('fk_detail_bill_materials_to_bill_materials');
        });
    }
};
