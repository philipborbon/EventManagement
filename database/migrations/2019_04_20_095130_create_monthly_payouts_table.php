<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonthlyPayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_payouts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid')->unsigned();
            $table->double('payout', 8, 2);
            $table->double('actualpayout', 8, 2)->nullable();
            $table->dateTime('dateavailable')->nullable();
            $table->dateTime('datecollected')->nullable();
            $table->timestamps();
            
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_payouts');
    }
}
