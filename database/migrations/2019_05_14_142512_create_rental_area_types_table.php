<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalAreaTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_area_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });

        Schema::table('rental_spaces', function (Blueprint $table) {
            $table->integer('typeid')->unsigned();
            $table->foreign('typeid')->references('id')->on('rental_area_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rental_spaces', function (Blueprint $table) {
            $table->dropForeign('rental_spaces_typeid_foreign');
            $table->dropColumn('typeid')->unsigned();
        });

        Schema::dropIfExists('rental_area_types');
    }
}
