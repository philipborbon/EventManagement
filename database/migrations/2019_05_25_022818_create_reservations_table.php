<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid')->unsigned();
            $table->integer('rentalspaceid')->unsigned();
            $table->enum('status', ['onhold', 'awarded', 'cancelled', 'waived']);
            $table->timestamps();

            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('rentalspaceid')->references('id')->on('rental_spaces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
