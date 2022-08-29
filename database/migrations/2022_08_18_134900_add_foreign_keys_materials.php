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
        Schema::table('materials', function (Blueprint $table) {
            $table->foreign('categories_id', 'fk_materials_to_categories')->references('id')->on('categories')->onUpdate('CASCADE');
            $table->foreign('measurements_id', 'fk_materials_to_measurements')->references('id')->on('measurements')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropForeign('fk_materials_to_categories');
            $table->dropForeign('fk_materials_to_measurements');
        });
    }
};
