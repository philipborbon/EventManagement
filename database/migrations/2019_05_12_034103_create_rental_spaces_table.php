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
            $table->integer('eventid')->unsigned();
            $table->text('name')->nullable();
            $table->text('location')->nullable();
            $table->double('area', 8, 2)->nullable();
            $table->enum('status', ['available', 'reserved', 'rented'])->default('available');
            $table->double('amount', 8, 2)->nullable();
            $table->timestamps();
            
            $table->foreign('eventid')->references('id')->on('events');
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
