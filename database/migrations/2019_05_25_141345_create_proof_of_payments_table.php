<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProofOfPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proof_of_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paymentid')->unsigned();
            $table->integer('documenttypeid')->unsigned();
            $table->string('attachment')->nullable();
            $table->timestamps();

            $table->foreign('paymentid')->references('id')->on('payments')->onDelete('cascade');
            $table->foreign('documenttypeid')->references('id')->on('document_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proof_of_payments');
    }
}
