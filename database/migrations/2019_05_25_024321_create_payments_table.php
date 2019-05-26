<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid')->unsigned();
            $table->integer('rentalspaceid')->unsigned();
            $table->integer('reservationid')->unsigned();
            $table->double('amount', 8, 2)->default(0);
            $table->boolean('verified')->default(false);
            $table->timestamps();

            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('rentalspaceid')->references('id')->on('rental_spaces')->onDelete('cascade');
            $table->foreign('reservationid')->references('id')->on('reservations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
