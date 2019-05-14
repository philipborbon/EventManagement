<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalSpacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_spaces', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description')->nullable();
            $table->text('location')->nullable();
            $table->double('area', 8, 2)->nullable();
            $table->boolean('available')->nullable();
            $table->double('amount', 8, 2)->nullable();
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
        Schema::dropIfExists('rental_spaces');
    }
}
